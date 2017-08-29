<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewLogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('view_log', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('enrollment_id')->unsigned();
            $table->integer('content_id')->unsigned();
            $table->Timestamp('datetime_view');
            $table->smallInteger('video_index_seconds');
            $table->foreign('content_id', 'fk_view_log_content_id')->on('contents')->references('id');
            $table->foreign('enrollment_id', 'fk_view_log_enrollment_id')->on('enrollments')->references('id');
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
        Schema::dropIfExists('view_log');
    }

}
