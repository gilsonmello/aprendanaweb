<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToConfigsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('configs', function(Blueprint $table) {
            $table->foreign('user_changed_id', 'fk_configs_1')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('configs', function(Blueprint $table) {
            $table->dropForeign('fk_configs_1');
        });
    }

}
