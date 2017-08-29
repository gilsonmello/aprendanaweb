<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCourseIdNameCourseContentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('course_contents', function(Blueprint $table) {
            $table->renameColumn('course', 'course_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('course_contents', function(Blueprint $table) {
            $table->renameColumn('course_id', 'course');
        });
    }

}
