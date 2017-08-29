<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentsCommentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('content_comments', function(Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->string('comment', 1000);
            $table->integer('likes');
            $table->tinyInteger('is_active')->default(0);
            $table->integer('contents_id')->unsigned();
            //$table->foreign('contents_id')->references('id')->on('contents');
            $table->integer('publisher_id')->unsigned();
            //$table->foreign('publisher_id')->references('id')->on('users');
            $table->integer('moderator_id')->unsigned();
            //$table->foreign('moderator_id')->references('id')->on('users');
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
        Schema::drop('content_comments');
    }

}
