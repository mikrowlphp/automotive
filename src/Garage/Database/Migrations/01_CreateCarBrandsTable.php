<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCarBrandsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('car_brands')) {
            Schema::create('car_brands', function (Blueprint $table) {
                $table->id();

                // Brand information
                $table->string('name');
                $table->string('logo')->nullable();
                $table->string('country')->nullable();
                $table->boolean('is_active')->default(true);

                $table->timestamps();

                // Indexes
                $table->index('name');
                $table->index('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS car_brands CASCADE');
    }
}
