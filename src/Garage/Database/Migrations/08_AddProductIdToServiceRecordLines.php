<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddProductIdToServiceRecordLines extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('service_record_lines')) {
            Schema::table('service_record_lines', function (Blueprint $table) {
                // Add product_id foreign key (nullable - not all lines are products)
                if (! Schema::hasColumn('service_record_lines', 'product_id')) {
                    // Soft reference cross-package (automotive -> sales/products)
                    $table->unsignedBigInteger('product_id')->nullable()->after('service_record_id');
                    $table->index('product_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('service_record_lines')) {
            Schema::table('service_record_lines', function (Blueprint $table) {
                // Drop foreign key and column
                if (Schema::hasColumn('service_record_lines', 'product_id')) {
                    DB::statement('ALTER TABLE service_record_lines DROP CONSTRAINT IF EXISTS service_record_lines_product_id_foreign');
                    $table->dropIndex(['product_id']);
                    $table->dropColumn('product_id');
                }
            });
        }
    }
}
