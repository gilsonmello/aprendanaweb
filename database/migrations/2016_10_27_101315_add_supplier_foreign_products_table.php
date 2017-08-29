<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupplierForeignProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function(Blueprint $table) {
            $table->unsignedInteger('suppliers_id');
            $table->foreign('suppliers_id', 'fk_products_suppliers_id')->on('suppliers')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('fk_products_suppliers_id');
            $table->dropColumn('suppliers_id');
        });
    }

}
