<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsEnrollmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('enrollments', function ($table) {
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id', 'fk_enrollments_order_id')->on('orders')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('enrollments', function ($table) {
            $table->dropColumn('order_id');
            $table->dropForeign('fk_enrollments_order_id');
        });
    }

}
