<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceTypeToServiceRecords extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('service_records')) {
            Schema::table('service_records', function (Blueprint $table) {
                // Add type column (nullable for existing records)
                if (! Schema::hasColumn('service_records', 'type')) {
                    $table->string('type')->nullable()->after('status');
                }

                // Add parameters column for type-specific data
                if (! Schema::hasColumn('service_records', 'parameters')) {
                    $table->json('parameters')->nullable()->after('type');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('service_records')) {
            Schema::table('service_records', function (Blueprint $table) {
                // Drop columns in reverse order
                if (Schema::hasColumn('service_records', 'parameters')) {
                    $table->dropColumn('parameters');
                }

                if (Schema::hasColumn('service_records', 'type')) {
                    $table->dropColumn('type');
                }
            });
        }
    }
}
