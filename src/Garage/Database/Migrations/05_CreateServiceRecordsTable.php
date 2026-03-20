<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateServiceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('service_records')) {
            Schema::create('service_records', function (Blueprint $table) {
                $table->id();

                // Foreign keys
                $table->foreignId('vehicle_id')
                    ->constrained('vehicles')
                    ->restrictOnDelete();

                $table->foreignId('customer_id')
                    ->constrained('contacts')
                    ->restrictOnDelete();

                // Service information
                $table->date('service_date');
                $table->integer('mileage_at_service')->nullable();
                $table->string('status')->default('pending'); // pending, in_progress, completed, cancelled
                $table->text('notes')->nullable();

                // Customer complaint and diagnosis
                $table->text('customer_complaint')->nullable();
                $table->text('diagnosis')->nullable();

                // Financial
                $table->decimal('total_amount', 15, 2)->default(0);

                $table->timestamps();
                $table->softDeletes();

                // Indexes
                $table->index('vehicle_id');
                $table->index('customer_id');
                $table->index('service_date');
                $table->index('status');
                $table->index(['vehicle_id', 'service_date']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS service_records CASCADE');
    }
}
