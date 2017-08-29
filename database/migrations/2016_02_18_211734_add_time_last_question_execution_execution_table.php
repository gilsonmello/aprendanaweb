<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeLastQuestionExecutionExecutionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('executions', function(Blueprint $table) {
            $table->string('time')->nullable();
            $table->integer('last_question_execution_id')->unsigned()->nullable();
            $table->foreign('last_question_execution_id')->references('id')->on('questions_executions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('executions', function(Blueprint $table) {
            $table->dropColumn('time');
            $table->dropForeign('last_question_execution_id');
            $table->dropColumn('last_question_execution_id');
        });
    }

}
