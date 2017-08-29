<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesAlertsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('courses_alerts', function(Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date')->nullable();
            $table->string('description', 1000)->nullable();
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id', 'fk_courses_alerts_course_id')->on('courses')->references('id');
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
        Schema::dropIfExists('courses_calendars');
    }

}
