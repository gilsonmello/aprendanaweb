<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackCartTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('track_cart', function(Blueprint $table) {
            $table->increments('id');
            $table->string('path', 100);
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('ip', 100);
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
        Schema::dropIfExists('track_cart');
    }

}
