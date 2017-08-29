<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreenrollmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('preenrollments', function(Blueprint $table) {
            $table->increments('id');

            $table->dateTime('date_email')->nullable();
            $table->dateTime('date_deadline')->nullable();
            $table->dateTime('date_activation')->nullable();

            $table->integer('partner_id')->unsigned();
            $table->foreign('partner_id', 'fk_preenrollments_partner_id')->references('id')->on('partners');

            $table->integer('course_id')->unsigned();
            $table->foreign('course_id', 'fk_preenrollments_course_id')->references('id')->on('courses');

            $table->integer('student_id')->unsigned();
            $table->foreign('student_id', 'fk_preenrollments_student_id')->references('id')->on('users');

            $table->integer('studentgroup_id')->unsigned()->nullable();
            $table->foreign('studentgroup_id', 'fk_preenrollments_studentgroup_id')->references('id')->on('studentgroups');

            $table->integer('partnerorder_id')->unsigned()->nullable();
            $table->foreign('partnerorder_id', 'fk_preenrollments_partnerorder_id')->references('id')->on('partnerorders');

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
        Schema::dropIfExists('studentgroups');
    }

}
