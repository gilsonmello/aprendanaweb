<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStateColumnsViewTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('view', function ($table) {
            $table->string('state', 1024)->nullable();
            $table->integer('percent')->unsigned()->nullable();
            $table->integer('accumulated_percent')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('view', function ($table) {
            $table->dropColumn('percent');
            $table->dropColumn('state');
            $table->dropColumn('accumulated_percent');
        });
    }

}
