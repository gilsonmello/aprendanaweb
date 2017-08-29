<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSuppliersIdProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function(Blueprint $table) {
            $table->renameColumn('suppliers_id', 'supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function(Blueprint $table) {
            $table->renameColumn('supplier_id', 'suppliers_id');
        });
    }

}
