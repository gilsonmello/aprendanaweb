<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerordersPaymentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('partnerorders', function(Blueprint $table) {
            $table->decimal('value', 9, 2)->nullable();
        });

        Schema::create('partnerorder_payments', function(Blueprint $table) {
            $table->increments('id');

            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->decimal('value', 9, 2);
            $table->decimal('paid_value', 9, 2)->nullable();

            $table->integer('partnerorder_id')->unsigned()->nullable();
//            $table->foreign('partnerorder_id', 'fk_partnerorder_payments_partnerorder_id')->references('id')->on('partnerorders');

            $table->integer('user_id_create')->unsigned();
            $table->foreign('user_id_create', 'fk_partnerorder_payments_user_id_create')->on('users')->references('id');

            $table->integer('user_id_paid')->unsigned()->nullable();
            $table->foreign('user_id_paid', 'fk_partnerorder_payments_user_id_paid')->on('users')->references('id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('partnerorders',function(Blueprint $table){
            $table->dropColumn('value');
        });

        Schema::dropIfExists('partnerorder_payments');
    }

}
