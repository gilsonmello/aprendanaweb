<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('states', function(Blueprint $table) {
            $table->foreign('country_id', 'fk_states_1')->on('countries')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('states', function(Blueprint $table) {
            $table->dropForeign('fk_states_1');
        });
    }

}
