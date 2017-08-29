<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonTeachersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lesson_teachers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->foreign('lesson_id', 'fk_lesson_teachers_1')->on('lessons')->references('id');
            $table->foreign('teacher_id', 'fk_lesson_teachers_2')->on('users')->references('id');
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
        Schema::dropIfExists('lesson_teachers');
    }

}
