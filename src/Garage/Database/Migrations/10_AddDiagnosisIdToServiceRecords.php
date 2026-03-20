<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDiagnosisIdToServiceRecords extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('service_records', 'diagnosis_id')) {
            Schema::table('service_records', function (Blueprint $table) {
                $table->foreignId('diagnosis_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('diagnoses')
                    ->nullOnDelete();
            });
        }

        // Drop old columns that moved to diagnoses table
        Schema::table('service_records', function (Blueprint $table) {
            if (Schema::hasColumn('service_records', 'customer_complaint')) {
                $table->dropColumn('customer_complaint');
            }
        });
        Schema::table('service_records', function (Blueprint $table) {
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
        if (Schema::hasColumn('service_records', 'diagnosis_id')) {
            DB::statement('ALTER TABLE service_records DROP CONSTRAINT IF EXISTS service_records_diagnosis_id_foreign');
            Schema::table('service_records', function (Blueprint $table) {
                $table->dropColumn('diagnosis_id');
            });
        }

        Schema::table('service_records', function (Blueprint $table) {
            if (! Schema::hasColumn('service_records', 'customer_complaint')) {
                $table->text('customer_complaint')->nullable();
            }
            if (! Schema::hasColumn('service_records', 'diagnosis')) {
                $table->text('diagnosis')->nullable();
            }
        });
    }
}
