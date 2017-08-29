<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsBooksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('exams_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('books_products_id');
            $table->foreign('books_products_id', 'fk_book_products_exams_books_id')->on('books')->references('products_id');
            $table->unsignedInteger('exams_id');
            $table->foreign('exams_id', 'fk_books_exams_id')->on('exams')->references('id');
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
        Schema::dropIfExists('exams_books');
    }

}
