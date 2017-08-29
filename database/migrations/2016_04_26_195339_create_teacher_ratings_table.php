<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherRatingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('teacher_ratings', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('content_rating')->nullable();
            $table->integer('teaching_rating')->nullable();
            $table->integer('teacher_id')->unsigned();
            $table->integer('exam_id')->unsigned();
            $table->integer('execution_id')->unsigned();
            $table->foreign('exam_id', 'fk_teacher_ratings_exams_id')->on('exams')->references('id');
            $table->foreign('execution_id', 'fk_teacher_ratings_executions_id')->on('executions')->references('id');
            $table->foreign('teacher_id', 'fk_teacher_ratings_teachers_id')->on('users')->references('id');

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
        Schema::dropIfExists('teacher_ratings');
    }

}
