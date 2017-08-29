<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeSpentMyWorkshopActivitiesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('my_workshop_activities', function(Blueprint $table) {
            $table->string('time_spent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('my_workshop_activities', function(Blueprint $table) {
            $table->dropColumn('time_spent');
        });
    }

}
