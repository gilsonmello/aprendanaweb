<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentgroupForeignEnrollmentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('enrollments', function(Blueprint $table) {
            $table->integer('studentgroup_id')->unsigned()->nullable();
            $table->foreign('studentgroup_id', 'fk_enrollments_studentgroup_id')->on('studentgroups')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
