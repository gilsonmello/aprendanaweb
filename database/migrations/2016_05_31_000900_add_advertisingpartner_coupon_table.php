<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdvertisingpartnerCouponTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('coupons', function ($table) {
            $table->integer('advertisingpartner_id')->unsigned()->nullable();
            $table->foreign('advertisingpartner_id')->references('id')->on('advertising_partners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('coupons', function ($table) {
            $table->dropColumn('advertisingpartner_id');
        });
    }

}
