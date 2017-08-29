<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivityForeignMyWorkshopTutorsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('my_workshop_tutors', function(Blueprint $table) {
            $table->integer('activity_id')->unsigned()->nullable();
            $table->foreign('activity_id', 'fk_my_workshop_tutors_activity_id')->on('workshop_activities')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('lessons', function(Blueprint $table) {
            $table->dropForeign('fk_my_workshop_tutors_activity_id');
            $table->dropColumn('activity_id');
        });
    }

}
