<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsMyWorkshopActivitiesTimeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('my_workshop_activities_time', function(Blueprint $table) {
            $table->foreign('activity_id', 'fk_activity_workshop_time_id')->on('workshop_activities')->references('id');
            $table->foreign('enrollment_id', 'fk_enrollment_workshop_time_id')->on('enrollments')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('my_workshop_activities_time', function(Blueprint $table) {
            $table->dropForeign('fk_activity_workshop_time_id');
            $table->dropForeign('fk_enrollment_workshop_time_id');
        });
    }

}
