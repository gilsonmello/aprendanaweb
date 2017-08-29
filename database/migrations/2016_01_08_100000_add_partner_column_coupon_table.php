<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPartnerColumnCouponTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('coupons', function ($table) {
            $table->smallInteger('institutional');
            $table->integer('partner_id')->unsigned()->nullable();
            $table->foreign('partner_id')->references('id')->on('partners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('coupons', function ($table) {
            $table->dropColumn('institutional');
            $table->dropColumn('partner_id');
        });
    }

}
