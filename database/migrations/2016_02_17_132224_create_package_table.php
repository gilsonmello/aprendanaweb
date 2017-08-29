<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('packages', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');

            $table->string('video_ad_url', 300)->nullable();
            $table->dateTime('activation_date')->nullable();
            $table->decimal('price', 10)->nullable();
            $table->decimal('discount_price', 10)->nullable();
            $table->dateTime('start_special_price')->nullable();
            $table->dateTime('end_special_price')->nullable();
            $table->decimal('special_price', 10)->nullable();

            $table->integer('subsection_id')->unsigned();
            $table->foreign('subsection_id')->references('id')->on('subsections');

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
        //
    }

}
