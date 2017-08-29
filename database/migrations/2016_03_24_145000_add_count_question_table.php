<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountQuestionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questions', function(Blueprint $table) {
            $table->integer('count_right')->default(0);
            $table->integer('count_wrong')->default(0);
            $table->integer('count_partial')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questions_executions', function(Blueprint $table) {
            $table->dropColumn('count_right');
            $table->dropColumn('count_wrong');
            $table->dropColumn('count_partial');
        });
    }

}
