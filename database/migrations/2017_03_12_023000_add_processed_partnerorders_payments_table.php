<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProcessedPartnerordersPaymentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('partnerorder_payments', function(Blueprint $table) {
            $table->integer('processed')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('partnerorder_payments',function(Blueprint $table){
            $table->dropColumn('processed');
        });
    }

}
