<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTagsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('tags', function(Blueprint $table) {
            $table->foreign('user_moderator_id', 'fk_tags_1')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('tags', function(Blueprint $table) {
            $table->dropForeign('fk_tags_1');
        });
    }

}
