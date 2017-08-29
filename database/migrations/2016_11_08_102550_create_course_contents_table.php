<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseContentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('course_contents', function(Blueprint $table) {
            $table->increments('id');

            $table->string('title', 200);
            $table->string('description', 250)->nullable();
            $table->string('url', 300);
            $table->tinyInteger('is_video')->default(0);
            $table->integer('sequence')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('course')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('course_contents', function(Blueprint $table) {
            $table->drop('course_contents');
        });
    }

}
