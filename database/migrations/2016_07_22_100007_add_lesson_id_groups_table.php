<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLessonIdGroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('groups', function(Blueprint $table) {
            $table->unsignedInteger('lesson_id')->nullable();
            $table->foreign('lesson_id', 'fk_groups_lesson')->on('lessons')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('groups', function(Blueprint $table) {
            $table->dropForeign('fk_groups_lesson');
            $table->dropColumn('lesson_id');
        });
    }

}
