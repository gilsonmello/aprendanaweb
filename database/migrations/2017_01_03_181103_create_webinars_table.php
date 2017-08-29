<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebinarsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('webinars', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longtext('description');
            $table->datetime('date');
            $table->string('youtube_live_url');
            $table->unsignedInteger('courses_id');
            $table->foreign('courses_id', 'fk_webinars_courses_id')->on('courses')->references('id');
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
          Schema::dropIfExists('webinars');
    }

}
