<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsUrlTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products_url', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('products_id');
            $table->foreign('products_id', 'fk_products_url_products_id')->on('products')->references('id');
            $table->string('url');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products_url');
    }

}
