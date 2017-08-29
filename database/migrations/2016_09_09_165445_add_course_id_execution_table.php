<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseIdExecutionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('executions', function(Blueprint $table) {
            $table->unsignedInteger('course_id')->nullable();
            $table->foreign('course_id', 'fk_course_executions')->on('courses')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('executions', function(Blueprint $table) {
            $table->dropForeign('fk_course_executions');
            $table->dropColumn('course_id');
        });
    }

}
