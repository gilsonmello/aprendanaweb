<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAverageGradeCoursesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function(Blueprint $table) {
            $table->unsignedInteger('times_executed')->default(0);
            $table->double('average_exam_grade')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('courses', function(Blueprint $table) {
            $table->dropColumn('times_executed');
            $table->dropColumn('average_exam_grade');
        });
    }

}
