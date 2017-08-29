<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseEnrollmentEnrollmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('enrollments', function(Blueprint $table) {
            $table->integer('course_enrollment_id')->unsigned()->nullable();
            $table->foreign('course_enrollment_id', 'fk_course_enrollment_enrollment_id')->on('enrollments')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('enrollments', function(Blueprint $table) {
            $table->dropForeign('fk_course_enrollment_enrollment_id');
            $table->dropIfExists('course_enrollment_id');
        });
    }

}
