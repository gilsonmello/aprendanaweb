<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPresentialLessonTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('lessons', function(Blueprint $table) {
            $table->boolean('presential')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('lessons', function(Blueprint $table) {
            $table->dropColumn('presential');
        });
    }

}
