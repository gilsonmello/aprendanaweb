<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWatchedTimeViewLogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('view_log', function(Blueprint $table) {
            $table->integer('watched_time')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('view_log', function(Blueprint $table) {
            $table->dropColumn('watched_time');
        });
    }

}
