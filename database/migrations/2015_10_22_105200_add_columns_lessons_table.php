<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsLessonsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('lessons', function ($table) {
            $table->integer('module_id')->unsigned()->nullable();
            $table->foreign('module_id', 'fk_lesson_module_id')->on('modules')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('lessons', function ($table) {
            $table->dropColumn('module_id');
        });
    }

}
