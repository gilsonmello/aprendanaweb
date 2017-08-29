<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOrderCourses extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_courses', function ($table) {
            $table->string('document_external_payment', 200)->nullable();
            $table->string('justification_external_payment', 200)->nullable();
            $table->integer('user_id_external_payment')->unsigned()->nullable();
            $table->foreign('user_id_external_payment', 'fk_order_courses_user_id_external_payment')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('order_courses', function ($table) {
            $table->dropForeign('fk_order_courses_user_id_external_payment');
            $table->dropColumn('user_id_external_payment');
            $table->dropColumn('document_external_payment');
            $table->dropColumn('justification_external_payment');
        });
    }

}
