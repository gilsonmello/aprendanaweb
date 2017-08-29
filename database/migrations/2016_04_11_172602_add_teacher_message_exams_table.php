<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeacherMessageExamsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('exams', function (Blueprint $table) {
            $table->integer('teacher_message_id')->unsigned()->nullable();
            $table->foreign('teacher_message_id', 'fk_exam_teacher_message_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('exams', function ($table) {
            $table->dropForeign('fk_exam_teacher_message_id');
            $table->dropColumn('teacher_message_id');
        });
    }

}
