<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLikesViewTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('view', function(Blueprint $table) {
            $table->smallInteger('like_content')->nullable();
            $table->smallInteger('like_teaching')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('view', function(Blueprint $table) {
            $table->dropIfExists('like_content');
            $table->dropIfExists('like_teaching');
        });
    }

}
