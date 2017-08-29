<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraColumnsQuestionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questions', function ($table) {
            $table->integer('institution_id')->unsigned()->nullable();
            $table->foreign('institution_id')->references('id')->on('institutions');

            $table->integer('office_id')->unsigned()->nullable();
            $table->foreign('office_id')->references('id')->on('offices');

            $table->integer('subject_id')->unsigned()->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects');

            $table->integer('source_id')->unsigned()->nullable();
            $table->foreign('source_id')->references('id')->on('sources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
