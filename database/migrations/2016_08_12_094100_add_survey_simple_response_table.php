<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSurveySimpleResponseTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('survey_simple_responses', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'fk_survey_simple_responses_user_id')->on('users')->references('id');
            $table->integer('survey_id')->unsigned();
            $table->foreign('survey_id', 'fk_survey_simple_responses_survey_id')->on('surveys')->references('id');
            $table->text('response');
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
        Schema::dropIfExists('survey_simple_responses');
    }

}
