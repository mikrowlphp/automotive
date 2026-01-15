<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('vehicles')) {
            Schema::create('vehicles', function (Blueprint $table) {
                $table->id();

                // Foreign keys
                $table->foreignId('customer_id')
                    ->constrained('contacts')
                    ->restrictOnDelete();

                $table->foreignId('car_model_id')
                    ->nullable()
                    ->constrained('car_models')
                    ->nullOnDelete();

                // Vehicle identification
                $table->string('license_plate')->unique();
                $table->string('vin')->nullable(); // Vehicle Identification Number
                $table->string('color')->nullable();
                $table->integer('year')->nullable();
                $table->integer('mileage')->nullable();

                // Technical details
                $table->string('fuel_type')->nullable(); // petrol, diesel, electric, hybrid, lpg, cng
                $table->string('engine')->nullable(); // e.g., "2.0 TDI", "1.6 16V"
                $table->text('notes')->nullable();
                $table->boolean('is_active')->default(true);

                $table->timestamps();
                $table->softDeletes();

                // Indexes
                $table->index('customer_id');
                $table->index('car_model_id');
                $table->index('license_plate');
                $table->index('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
}
