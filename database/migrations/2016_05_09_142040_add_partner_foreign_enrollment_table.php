<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPartnerForeignEnrollmentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('enrollments', function(Blueprint $table) {
            $table->integer('partner_id')->unsigned()->nullable();
            $table->foreign('partner_id', 'fk_enrollments_partner_id')->on('partners')->references('id');
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
