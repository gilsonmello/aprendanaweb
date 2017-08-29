<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeacherQuestionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questions', function ($table) {
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->foreign('teacher_id', 'fk_questions_teacher_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('enrollments', function ($table) {
            $table->dropForeign('fk_questions_teacher_id');
            $table->dropColumn('teacher_id');
        });
    }

}
