<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentNotesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('content_notes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->integer('content_id')->unsigned();
            $table->Timestamp('date');
            $table->smallInteger('video_index_seconds');
            $table->text('note');
            $table->foreign('content_id', 'fk_content_notes_1')->on('contents')->references('id');
            $table->foreign('student_id', 'fk_content_notes_2')->on('users')->references('id');
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
        Schema::dropIfExists('content_notes');
    }

}
