<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('products_id');
            $table->foreign('products_id', 'fk_books_products_id')->on('products')->references('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'fk_books_user_id')->on('users')->references('id');
            $table->string('subject', 30);
            $table->string('title', 50);
            $table->integer('author_id')->nullable();
            $table->string('author_name');
            $table->boolean('pages')->nullable();
            $table->float('isbn')->nullable();
            $table->string('slug');
            $table->string('dimensions', 10)->nullable();
            $table->char('edition', 4)->nullable();
            $table->char('release', 4)->nullable();
            $table->string('stuff', 30)->nullable();
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
        Schema::dropIfExists('books');
    }

}
