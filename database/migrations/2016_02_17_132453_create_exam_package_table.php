<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamPackageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('exam_packages', function(Blueprint $table) {
            $table->increments('id');


            $table->integer('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('packages');

            $table->integer('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams');


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
        //
    }

}
