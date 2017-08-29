<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOccupationForeignUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function(Blueprint $table) {
            $table->integer('occupation_id')->unsigned()->nullable();
            $table->foreign('occupation_id', 'fk_users_occupation_id')->on('occupations')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('fk_users_occupation_id');
            $table->dropColumn('occupation_id');
        });
    }

}
