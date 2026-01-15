<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRecordLinesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('service_record_lines')) {
            Schema::create('service_record_lines', function (Blueprint $table) {
                $table->id();

                // Foreign keys
                $table->foreignId('service_record_id')
                    ->constrained('service_records')
                    ->cascadeOnDelete();

                // Line item details
                $table->string('type'); // labor, part, material, other
                $table->text('description');
                $table->decimal('quantity', 15, 2)->default(1);
                $table->decimal('unit_price', 15, 2)->default(0);
                $table->decimal('line_total', 15, 2)->default(0);

                $table->timestamps();

                // Indexes
                $table->index('service_record_id');
                $table->index('type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_record_lines');
    }
}
