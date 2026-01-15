<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('car_models')) {
            Schema::create('car_models', function (Blueprint $table) {
                $table->id();

                // Foreign keys
                $table->foreignId('car_brand_id')
                    ->constrained('car_brands')
                    ->restrictOnDelete();

                // Model information
                $table->string('name');
                $table->integer('year_from')->nullable();
                $table->integer('year_to')->nullable();
                $table->string('body_type')->nullable(); // sedan, suv, coupe, convertible, wagon, hatchback, etc.
                $table->boolean('is_active')->default(true);

                $table->timestamps();

                // Indexes
                $table->index('car_brand_id');
                $table->index('name');
                $table->index('is_active');
                $table->index(['car_brand_id', 'name']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
}
