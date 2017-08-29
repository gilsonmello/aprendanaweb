<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAskTheTeacherTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ask_the_teacher', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned()->nullable();
            $table->integer('lesson_id')->unsigned()->nullable();
            $table->integer('user_student_id')->unsigned();
            $table->integer('user_teacher_id')->unsigned()->nullable();
            $table->text('question', 2000);
            $table->text('answer', 10000)->nullable();
            $table->Timestamp('date_question');
            $table->Timestamp('date_answer')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ask_the_teacher_history', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_teacher_pre_id')->unsigned();
            $table->integer('user_teacher_pos_id')->unsigned();
            $table->Timestamp('date_change');
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
        Schema::drop('ask_the_teacher');
        Schema::drop('ask_the_teacher_history');
    }

}
