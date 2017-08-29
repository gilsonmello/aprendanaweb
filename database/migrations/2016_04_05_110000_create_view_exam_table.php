<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewExamTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('view_exams', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('enrollment_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->smallInteger('max_view');
            $table->smallInteger('view');
            $table->foreign('question_id', 'fk_view_exams_question_id')->on('questions')->references('id');
            $table->foreign('enrollment_id', 'fk_view_exams_enrollment_id')->on('enrollments')->references('id');
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
        Schema::dropIfExists('view_exams');
    }

}
