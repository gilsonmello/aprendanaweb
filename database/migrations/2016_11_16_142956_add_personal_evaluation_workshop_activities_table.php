<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPersonalEvaluationWorkshopActivitiesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('workshop_activities', function(Blueprint $table) {
            $table->smallInteger('personal_evaluation')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('workshop_activities', function(Blueprint $table) {
            $table->dropColumn('personal_evaluation');
        });
    }

}
