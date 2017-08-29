<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotesQuestionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questions', function ($table) {
            $table->text('note1', 65535)->nullable();
            $table->text('note2', 65535)->nullable();
            $table->text('note3', 65535)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questions', function ($table) {
            $table->dropColumn('note1');
            $table->dropColumn('note2');
            $table->dropColumn('note3');
        });
    }

}
