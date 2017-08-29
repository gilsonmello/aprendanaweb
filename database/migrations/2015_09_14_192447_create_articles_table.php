<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('articles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title', 250)->nullable();
            $table->dateTime('date')->nullable();
            $table->text('content', 65535)->nullable();
            $table->string('tags', 250)->nullable();
            $table->string('link')->nullable();
            $table->string('img')->nullable();
            $table->dateTime('activation_date')->nullable();
            $table->string('slug', 250)->nullable();
            $table->string('video', 250)->nullable();
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
        Schema::dropIfExists('articles');
    }

}
