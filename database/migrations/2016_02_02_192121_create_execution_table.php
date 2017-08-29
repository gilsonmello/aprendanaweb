<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExecutionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('executions', function(Blueprint $table) {
            $table->increments('id');


            $table->integer('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams');

            $table->integer('enrollment_id')->unsigned();
            $table->foreign('enrollment_id')->references('id')->on('enrollments');

            $table->integer('attempt')->nullable;

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
        Schema::dropIfExists('executions');
    }

}
