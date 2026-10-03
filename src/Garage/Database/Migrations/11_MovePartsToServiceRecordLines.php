<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The parts of the mechanics, electrician and bodywork forms lived in the `parameters` JSON, without a
 * price. They become priced lines of type "part", so a part is recorded in one place only.
 *
 * The JSON had no price, so the lines start at zero and the total amount of the record is left as it is.
 */
class MovePartsToServiceRecordLines extends Migration
{
    /**
     * `parts_replaced` belongs to the mechanics form, `parts_used` to the electrician and bodywork ones.
     */
    private const PART_KEYS = ['parts_used', 'parts_replaced'];

    public function up(): void
    {
        if (! Schema::hasTable('service_records') || ! Schema::hasTable('service_record_lines')) {
            return;
        }

        DB::table('service_records')->whereNotNull('parameters')->orderBy('id')->chunkById(200, function ($records): void {
            foreach ($records as $record) {
                $parameters = json_decode($record->parameters, true);

                if (! is_array($parameters) || ! array_intersect(self::PART_KEYS, array_keys($parameters))) {
                    continue;
                }

                $parts = collect(self::PART_KEYS)
                    ->flatMap(fn (string $key): array => is_array($parameters[$key] ?? null) ? $parameters[$key] : [])
                    ->filter(fn (mixed $part): bool => is_array($part) && (filled($part['product_id'] ?? null) || filled($part['note'] ?? null)));

                DB::transaction(function () use ($record, $parameters, $parts): void {
                    $now = now();

                    DB::table('service_record_lines')->insert($parts->map(fn (array $part): array => [
                        'service_record_id' => $record->id,
                        'product_id' => filled($part['product_id'] ?? null) ? (int) $part['product_id'] : null,
                        'type' => 'part',
                        'description' => $this->describe($part),
                        'quantity' => (float) ($part['quantity'] ?? 0) ?: 1,
                        'unit_price' => 0,
                        'line_total' => 0,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ])->values()->all());

                    DB::table('service_records')->where('id', $record->id)->update([
                        'parameters' => json_encode((object) array_diff_key($parameters, array_flip(self::PART_KEYS))),
                    ]);
                });
            }
        });
    }

    /**
     * Puts the part lines back into the JSON of their form, and removes them.
     */
    public function down(): void
    {
        if (! Schema::hasTable('service_records') || ! Schema::hasTable('service_record_lines')) {
            return;
        }

        $recordIds = DB::table('service_record_lines')->where('type', 'part')->whereNotNull('product_id')->distinct()->pluck('service_record_id');

        foreach ($recordIds as $recordId) {
            $record = DB::table('service_records')->where('id', $recordId)->first();

            if (! $record) {
                continue;
            }

            $lines = DB::table('service_record_lines')
                ->where('service_record_id', $recordId)
                ->where('type', 'part')
                ->whereNotNull('product_id')
                ->orderBy('id')
                ->get();

            $parameters = json_decode($record->parameters ?? '[]', true) ?: [];
            $parameters[$record->type === 'mechanics' ? 'parts_replaced' : 'parts_used'] = $lines->map(fn ($line): array => [
                'product_id' => (int) $line->product_id,
                'quantity' => (float) $line->quantity,
                'note' => null,
            ])->all();

            DB::transaction(function () use ($recordId, $parameters, $lines): void {
                DB::table('service_records')->where('id', $recordId)->update(['parameters' => json_encode($parameters)]);
                DB::table('service_record_lines')->whereIn('id', $lines->pluck('id'))->delete();
            });
        }
    }

    /**
     * The product name, as the old part select showed it, followed by the note of the part.
     *
     * @param  array<string, mixed>  $part
     */
    private function describe(array $part): string
    {
        $name = null;

        if (filled($part['product_id'] ?? null) && Schema::hasTable('products')) {
            $product = DB::table('products')->where('id', $part['product_id'])->first(['name', 'full_name']);
            $name = $product?->full_name ?: $product?->name;
        }

        $name ??= filled($part['product_id'] ?? null) ? '#'.$part['product_id'] : null;

        return collect([$name, $part['note'] ?? null])->filter(fn (?string $value): bool => filled($value))->implode(' - ');
    }
}
