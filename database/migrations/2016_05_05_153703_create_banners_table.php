<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name', 50);
            $table->text('url', 400);
            $table->text('img', 100);
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id', 'fk_banners_course_id')->on('courses')->references('id');
            $table->integer('exam_id')->unsigned()->nullable();
            $table->foreign('exam_id', 'fk_banners_exam_id')->on('exams')->references('id');
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
        Schema::dropIfExists('banners');
    }

}
