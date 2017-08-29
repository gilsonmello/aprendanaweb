<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndividualCertification extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function ($table) {
            $table->integer('certification_individual_auth')->unsigned()->default( 0 );
            $table->string('certification_individual_text', 100);
        });

        Schema::table('enrollments', function ($table) {
            $table->datetime('certification_individual_date')->nullable();
            $table->integer('certification_individual_user_id')->unsigned()->nullable();
            $table->foreign('certification_individual_user_id', 'fk_certification_individual_user_id')->on('users')->references('id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('enrollments', function ($table) {
            $table->dropForeign('fk_certification_individual_user_id');
            $table->dropColumn('certification_individual_user_id');
            $table->dropColumn('certification_individual_date');
        });
        Schema::table('courses', function ($table) {
            $table->dropColumn('certification_individual_auth');
            $table->dropColumn('certification_individual_text');
        });
    }

}
