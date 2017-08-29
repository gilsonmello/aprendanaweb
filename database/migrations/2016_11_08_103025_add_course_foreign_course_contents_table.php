<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseForeignCourseContentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('course_contents', function(Blueprint $table) {
            $table->foreign('course', 'fk_course_course_contents_id')->on('courses')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('course_contents', function(Blueprint $table) {
            $table->dropForeign('fk_course_course_contents_id');
        });
    }

}
