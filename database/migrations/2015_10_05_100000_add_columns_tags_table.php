<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTagsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('tags', function ($table) {
            $table->integer('user_moderator_id')->unsigned()->nullable();
            $table->datetime('active_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('tags', function ($table) {
            $table->dropColumn('user_moderator_id');
            $table->dropColumn('active_at');
        });
    }

}
