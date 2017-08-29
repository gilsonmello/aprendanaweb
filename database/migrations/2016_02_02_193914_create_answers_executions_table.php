<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersExecutionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('answers_executions', function(Blueprint $table) {
            $table->increments('id');


            $table->integer('question_execution_id')->unsigned();
            $table->foreign('question_execution_id')->references('id')->on('questions_executions');

            $table->integer('answer_id')->unsigned();
            $table->foreign('answer_id')->references('id')->on('answers');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('answers_executions');
    }

}
