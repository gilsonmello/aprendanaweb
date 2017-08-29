<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLessonsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lessons', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title', 150);
            $table->string('description', 250)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->string('tags', 1000)->nullable();
            $table->integer('sequence');
            $table->string('featured_img', 255)->nullable();
            $table->time('duration')->nullable();
            $table->dateTime('activation_date')->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('subsection_id')->unsigned();
            //$table->foreign('subsection_id')->references('id')->on('subsections');
            $table->string('video_ad_url', 255)->nullable();
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
        Schema::dropIfExists('lessons');
    }

}
