<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('videos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->nullable();
            $table->string('slug')->nullable();
            $table->string('url')->nullable();
            $table->text('content', 65535)->nullable();
            $table->string('tags', 250)->nullable();
            $table->string('img')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('videos');
    }

}
