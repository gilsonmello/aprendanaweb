<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesAggregatedExamsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('courses_aggregated_exams', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('course_id_bought')->unsigned()->nullable();
            $table->foreign('course_id_bought')->references('id')->on('courses');

            $table->integer('exam_id_extra')->unsigned()->nullable();
            $table->foreign('exam_id_extra')->references('id')->on('exams');
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
