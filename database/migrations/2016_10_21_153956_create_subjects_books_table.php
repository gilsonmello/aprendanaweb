<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsBooksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('subjects_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('books_products_id');
            $table->foreign('books_products_id', 'fk_book_products_subjects_id')->on('books')->references('products_id');
            $table->unsignedInteger('subjects_id');
            $table->foreign('subjects_id', 'fk_subjects_books_subjects_id')->on('subjects')->references('id');
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
        Schema::dropIfExists('subjects_books');
    }

}
