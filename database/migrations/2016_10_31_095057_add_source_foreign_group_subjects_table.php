<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourceForeignGroupSubjectsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('group_subject', function(Blueprint $table) {
            $table->unsignedInteger('source_id')->nullable();
            $table->foreign('source_id', 'fk_source_group_subject_id')->on('sources')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('group_subjects', function(Blueprint $table) {
            $table->dropForeign('fk_source_group_subject_id');
            $table->dropColumn('source_id');
        });
    }

}
