<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExamForeignLessonTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('lessons', function(Blueprint $table) {
            $table->integer('exam_id')->unsigned()->nullable();
            $table->foreign('exam_id', 'fk_exam_lesson_id')->on('exams')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('lessons', function(Blueprint $table) {
            $table->dropForeign('fk_exam_lesson_id');
            $table->dropColumn('exam_id');
        });
    }

}
