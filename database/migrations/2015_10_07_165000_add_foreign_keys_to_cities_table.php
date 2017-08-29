<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCitiesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('cities', function(Blueprint $table) {
            $table->foreign('state_id', 'fk_cities_1')->on('states')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('cities', function(Blueprint $table) {
            $table->dropForeign('fk_cities_1');
        });
    }

}
