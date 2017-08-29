<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserCouponsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('coupons', function(Blueprint $table) {
            $table->integer('user_id_created_by')->unsigned()->nullable();
            $table->foreign('user_id_created_by', 'fk_coupons_user_id_created_by')->on('users')->references('id');
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
