<?php

namespace Packages\Automotive\Garage\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
                    $table->foreignId('product_id')
                        ->nullable()
                        ->after('service_record_id')
                        ->constrained('products')
                        ->nullOnDelete();

                    // Add index for product_id
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
                    // Drop index first
                    $table->dropIndex(['product_id']);

                    // Drop foreign key constraint
                    $table->dropForeign(['product_id']);

                    // Drop column
                    $table->dropColumn('product_id');
                }
            });
        }
    }
}
