<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLessonIdExecutionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('executions', function(Blueprint $table) {
            $table->unsignedInteger('lesson_id')->nullable();
            $table->foreign('lesson_id', 'fk_lesson_executions')->on('lessons')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('executions', function(Blueprint $table) {
            $table->dropForeign('fk_lesson_executions');
            $table->dropColumn('lesson_id');
        });
    }

}
