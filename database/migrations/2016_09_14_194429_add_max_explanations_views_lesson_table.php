<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaxExplanationsViewsLessonTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('lessons', function(Blueprint $table) {
            $table->unsignedInteger('max_explanations_views')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('lessons', function(Blueprint $table) {
            $table->dropColumn('max_explanations_views');
        });
    }

}
