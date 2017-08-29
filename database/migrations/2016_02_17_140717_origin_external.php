<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OriginExternal extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('origin_external', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('slug', 100);
            $table->string('source', 100);
            $table->string('medium', 100);
            $table->string('campaign', 100);
            $table->integer('order_id')->unsigned()->nullable();
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
        Schema::dropIfExists('origin_external');
    }

}
