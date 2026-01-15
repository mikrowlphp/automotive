<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('diagnoses')) {
            Schema::create('diagnoses', function (Blueprint $table) {
                $table->id();

                // Foreign keys
                $table->foreignId('vehicle_id')
                    ->constrained('vehicles')
                    ->cascadeOnDelete();

                $table->foreignId('customer_id')
                    ->constrained('contacts')
                    ->cascadeOnDelete();

                // Diagnosis information
                $table->date('acceptance_date');
                $table->integer('mileage_at_acceptance')->nullable();
                $table->text('customer_complaint')->nullable();
                $table->text('initial_diagnosis')->nullable();
                $table->string('status')->default('draft'); // draft, open, closed
                $table->text('notes')->nullable();

                $table->timestamps();
                $table->softDeletes();

                // Indexes
                $table->index('vehicle_id');
                $table->index('customer_id');
                $table->index('status');
                $table->index(['vehicle_id', 'acceptance_date']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
}
