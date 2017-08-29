<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerManagersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('partner_managers', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('partner_id')->unsigned();
            $table->foreign('partner_id', 'fk_partner_managers_partners_id')->references('id')->on('partners');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'fk_partner_managers_users_id')->references('id')->on('users');


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
        
    }

}
