<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name', 50);
            $table->text('url', 400);
            $table->text('img', 100);
            $table->char('orientation', 1);
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
        Schema::dropIfExists('sliders');
    }

}
