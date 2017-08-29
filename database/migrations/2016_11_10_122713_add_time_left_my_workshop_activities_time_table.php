<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeLeftMyWorkshopActivitiesTimeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('my_workshop_activities_time', function(Blueprint $table) {
            $table->string('time_left')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('my_workshop_activities_time', function(Blueprint $table) {
            $table->dropColumn('time_left');
        });
    }

}
