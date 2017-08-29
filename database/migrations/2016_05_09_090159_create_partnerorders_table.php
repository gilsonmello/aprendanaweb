<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerordersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('partnerorders', function(Blueprint $table) {
            $table->increments('id');

            $table->text('html_email', 65535)->nullable();
            $table->text('html_subscribe', 65535)->nullable();
            $table->integer('total_enrollments');
            $table->integer('used_enrollments');
            $table->text('external_course_id', 30)->nullable();
            $table->dateTime('date')->nullable();
            $table->text('invoice', 10)->nullable();

            $table->integer('partner_id')->unsigned()->nullable();
            $table->foreign('partner_id', 'fk_partnerorders_partner_id')->references('id')->on('partners');

            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id', 'fk_partnerorders_course_id')->references('id')->on('courses');

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
        Schema::dropIfExists('partnerorders');
    }

}
