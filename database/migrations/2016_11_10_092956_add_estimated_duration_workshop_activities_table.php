<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstimatedDurationWorkshopActivitiesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('workshop_activities', function(Blueprint $table) {
            $table->unsignedInteger('estimated_duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('workshop_activities', function(Blueprint $table) {
            $table->dropColumn('estimated_duration');
        });
    }

}
