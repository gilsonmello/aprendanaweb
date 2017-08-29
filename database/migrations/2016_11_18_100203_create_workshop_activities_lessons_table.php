<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopActivitiesLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_activities_lessons', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('workshop_activity_id')->unsigned()->nullable();
            $table->foreign('workshop_activity_id','fk_workshop_activities_activity_id')->references('id')->on('workshop_activities');

            $table->integer('lesson_id')->unsigned()->nullable();
            $table->foreign('lesson_id','fk_workshop_acitivities_lessons_id')->references('id')->on('lessons');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('workshop_activities_lessons');
    }
}
