<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExecutionForeignViewExamsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('view_exams', function(Blueprint $table) {
            $table->integer('execution_id')->unsigned()->nullable();
            $table->foreign('execution_id', 'fk_execution_view_exams_id')->on('executions')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('view_exams', function(Blueprint $table) {
            $table->dropForeign('fk_execution_view_exams_id');
            $table->dropColumn('execution_id');
        });
    }

}
