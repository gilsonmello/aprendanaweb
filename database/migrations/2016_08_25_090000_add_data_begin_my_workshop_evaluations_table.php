<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataBeginMyWorkshopEvaluationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('my_workshop_evaluations', function ($table) {
            $table->date('date_begin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('my_workshop_evaluations', function ($table) {
            $table->dropColumn('date_begin');
        });
    }

}
