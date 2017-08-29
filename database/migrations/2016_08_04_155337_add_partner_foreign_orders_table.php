<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPartnerForeignOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function(Blueprint $table) {
            $table->integer('partner_id')->unsigned()->nullable();
            $table->foreign('partner_id', 'fk_orders_partner_id')->on('partners')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('orders', function(Blueprint $table) {
            $table->dropForeign('fk_orders_partner_id');
            $table->dropColumn('partner_id');
        });
    }

}
