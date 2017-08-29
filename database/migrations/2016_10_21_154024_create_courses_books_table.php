<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesBooksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('course_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('books_products_id');
            $table->foreign('books_products_id', 'fk_book_products_course_books_id')->on('books')->references('products_id');
            $table->unsignedInteger('courses_id');
            $table->foreign('courses_id', 'fk_books_courses_id')->on('courses')->references('id');
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
        Schema::dropIfExists('course_books');
    }

}
