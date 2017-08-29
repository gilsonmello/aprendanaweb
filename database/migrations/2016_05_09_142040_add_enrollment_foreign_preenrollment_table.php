<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnrollmentForeignPreenrollmentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('preenrollments', function(Blueprint $table) {
            $table->integer('enrollment_id')->unsigned()->nullable();
            $table->foreign('enrollment_id', 'fk_preenrollments_enrollment_id')->on('enrollments')->references('id');
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
