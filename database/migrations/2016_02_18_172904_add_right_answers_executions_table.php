<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRightAnswersExecutionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('answers_executions', function(Blueprint $table) {
            $table->boolean('is_right');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('answers_executions', function(Blueprint $table) {
            $table->dropColumn('is_right');
        });
    }

}
