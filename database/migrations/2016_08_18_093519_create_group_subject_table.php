<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupSubjectTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('group_subject', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id', 'fk_group_group_subjects')->references('id')->on('groups');
            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id', 'fk_subject_group_subjects')->references('id')->on('subjects');
            $table->unsignedInteger('questions_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('group_subject', function(Blueprint $table) {
            $table->dropForeign('fk_group_group_subjects');
            $table->dropForeign('fk_subject_group_subjects');
        });

        Schema::dropIfExists('group_subjects');
    }

}
