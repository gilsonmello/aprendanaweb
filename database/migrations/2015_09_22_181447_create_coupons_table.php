<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('coupons', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->string('code', 100)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->integer('limit')->nullable();
            $table->integer('used')->nullable();
            $table->decimal('percentage', 7, 4)->nullable();
            $table->decimal('value', 7, 2)->nullable();
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
        Schema::dropIfExists('coupons');
    }

}
