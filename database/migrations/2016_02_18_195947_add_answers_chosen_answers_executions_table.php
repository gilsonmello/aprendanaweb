<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnswersChosenAnswersExecutionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('answers_executions', function(Blueprint $table) {
            $table->text('answers_chosen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('answers_executions', function(Blueprint $table) {
            $table->dropColumn('answers_chosen');
        });
    }

}
