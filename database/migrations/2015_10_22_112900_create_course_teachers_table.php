<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTeachersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('course_teachers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->foreign('course_id', 'fk_course_teachers_1')->on('courses')->references('id');
            $table->foreign('teacher_id', 'fk_course_teachers_2')->on('users')->references('id');
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
        Schema::dropIfExists('course_teachers');
    }

}
