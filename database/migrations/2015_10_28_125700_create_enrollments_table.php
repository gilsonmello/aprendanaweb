<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('enrollments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->integer('course_id')->unsigned()->nullable();
            $table->integer('module_id')->unsigned()->nullable();
            $table->integer('lesson_id')->unsigned()->nullable();
            $table->Timestamp('date_begin');
            $table->Timestamp('date_end');
            $table->smallInteger('is_active');
            $table->smallInteger('is_paid');
            $table->foreign('course_id', 'fk_enrollments_course_id')->on('courses')->references('id');
            $table->foreign('module_id', 'fk_enrollments_module_id')->on('modules')->references('id');
            $table->foreign('lesson_id', 'fk_enrollments_lesson_id')->on('lessons')->references('id');
            $table->foreign('student_id', 'fk_enrollments_student_id')->on('users')->references('id');
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
        Schema::dropIfExists('enrollments');
    }

}
