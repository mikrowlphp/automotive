<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarVariantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('car_variants')) {
            Schema::create('car_variants', function (Blueprint $table) {
                $table->id();

                // Foreign keys
                $table->foreignId('car_model_id')
                    ->constrained('car_models')
                    ->cascadeOnDelete();

                // Engine information
                $table->string('name'); // e.g., "1.6 BlueHDi Active"
                $table->string('engine_code')->nullable(); // e.g., "DV6C", "EB2"
                $table->string('engine_name')->nullable(); // e.g., "BlueHDi", "PureTech"
                $table->integer('displacement')->nullable(); // in cc, e.g., 1560
                $table->integer('power_kw')->nullable(); // e.g., 75
                $table->integer('power_hp')->nullable(); // e.g., 102
                $table->integer('torque_nm')->nullable(); // e.g., 254

                // Classification
                $table->string('fuel_type'); // petrol, diesel, electric, hybrid, etc.
                $table->string('transmission')->nullable(); // manual, automatic, cvt
                $table->string('body_type')->nullable(); // hatchback, sedan, suv, etc.
                $table->integer('doors')->nullable(); // 3, 5, etc.

                // Production years
                $table->integer('year_from')->nullable();
                $table->integer('year_to')->nullable();

                $table->boolean('is_active')->default(true);

                $table->timestamps();

                // Indexes
                $table->index('car_model_id');
                $table->index('fuel_type');
                $table->index('transmission');
                $table->index('is_active');
                $table->index(['car_model_id', 'name']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_variants');
    }
}
