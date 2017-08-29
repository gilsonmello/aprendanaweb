<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErrorLogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('error_logs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('error_name');
            $table->unsignedInteger('user_id');
            $table->string('user_agent');
            $table->unsignedInteger('enrollment')->nullable();
            $table->unsignedInteger('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('error_logs');
    }

}
