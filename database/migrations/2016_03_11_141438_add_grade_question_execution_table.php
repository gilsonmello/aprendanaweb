<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGradeQuestionExecutionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questions_executions', function(Blueprint $table) {
            $table->float('grade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questions_executions', function(Blueprint $table) {
            $table->dropColumn('grade');
        });
    }

}
