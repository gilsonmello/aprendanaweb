<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderPackages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('order_packages', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('package_id')->unsigned();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id', 'fk_order_packages_order_id')->on('orders')->references('id');
            $table->foreign('package_id', 'fk_order_packages_package_id')->on('packages')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('order_packages');
    }

}
