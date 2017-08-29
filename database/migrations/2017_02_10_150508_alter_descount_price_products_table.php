<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDescountPriceProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function(Blueprint $table) {
            $table->renameColumn('price_descount', 'discount_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function(Blueprint $table) {
            $table->renameColumn('discount_price', 'price_descount');
        });
    }

}
