<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesAggregatedCoursesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('courses_aggregated_courses', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('course_id_bought')->unsigned()->nullable();
            $table->foreign('course_id_bought')->references('id')->on('courses');

            $table->integer('course_id_extra')->unsigned()->nullable();
            $table->foreign('course_id_extra')->references('id')->on('courses');
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
