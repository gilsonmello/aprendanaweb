<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRepresentativeCouponsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('coupons', function(Blueprint $table) {
            $table->integer('user_id_representative')->unsigned()->nullable();
            $table->foreign('user_id_representative', 'fk_coupons_user_id_representative')->on('users')->references('id');
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
