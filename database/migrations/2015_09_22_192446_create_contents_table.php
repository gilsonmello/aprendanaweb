<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contents', function(Blueprint $table) {
            $table->increments('id');

            $table->string('title', 200);
            $table->string('description', 250)->nullable();
            $table->string('url', 300);
            $table->tinyInteger('is_video')->default(0);
            $table->tinyInteger('is_free')->default(0);
            $table->integer('sequence')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('lesson_id')->unsigned();
            //$table->foreign('lesson_id')->references('id')->on('lesson');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('contents');
    }

}
