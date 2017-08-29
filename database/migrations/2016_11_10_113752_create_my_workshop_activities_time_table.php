<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyWorkshopActivitiesTimeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('my_workshop_activities_time', function(Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('activity_id');
            $table->unsignedInteger('enrollment_id');
            $table->string('time_spent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('my_workshop_activities_time');
    }

}
