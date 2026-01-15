<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiagnosisIdToServiceRecords extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_records', function (Blueprint $table) {
            // Add diagnosis_id foreign key
            $table->foreignId('diagnosis_id')
                ->nullable()
                ->after('id')
                ->constrained('diagnoses')
                ->nullOnDelete();

            // Drop old columns that moved to diagnoses table
            if (Schema::hasColumn('service_records', 'customer_complaint')) {
                $table->dropColumn('customer_complaint');
            }
            if (Schema::hasColumn('service_records', 'diagnosis')) {
                $table->dropColumn('diagnosis');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_records', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['diagnosis_id']);
            $table->dropColumn('diagnosis_id');

            // Restore old columns
            $table->text('customer_complaint')->nullable();
            $table->text('diagnosis')->nullable();
        });
    }
}
