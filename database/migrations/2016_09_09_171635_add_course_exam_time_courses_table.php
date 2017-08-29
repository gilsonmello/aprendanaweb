<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseExamTimeCoursesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function(Blueprint $table) {
            $table->unsignedInteger('exam_duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('courses', function(Blueprint $table) {
            $table->dropColumn('exam_duration');
        });
    }

}
