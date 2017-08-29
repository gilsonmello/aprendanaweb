<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopGroupTutorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('workshops', function ($table) {
            $table->smallInteger('evaluation_type')->default(0);
        });

        Schema::create('workshop_evaluation_groups', function(Blueprint $table) {
            $table->increments('id');
            $table->string('description', 300);
            $table->integer('workshop_id')->unsigned()->nullable();
            $table->foreign('workshop_id', 'fk_workshop_evaluation_groups_workshop')->on('workshops')->references('id');
            $table->smallInteger('position')->nullable();
            $table->smallInteger('max_students')->nullable();
            $table->smallInteger('num_students')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('workshop_group_tutors', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workshop_evaluation_group_id')->unsigned()->nullable();
            $table->foreign('workshop_evaluation_group_id', 'fk_workshop_group_tutors_workshop_evaluation_group')->on('workshop_evaluation_groups')->references('id');
            $table->integer('tutor_id')->unsigned()->nullable();
            $table->foreign('tutor_id', 'fk_workshop_group_tutors_tutor')->on('users')->references('id');
            $table->integer('activity_id')->unsigned()->nullable();
            $table->foreign('activity_id', 'fk_workshop_group_tutors_activity')->on('workshop_activities')->references('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('workshops', function ($table) {
            $table->dropColumn('evaluation_type');
        });

        Schema::dropIfExists('workshop_evaluation_groups');
        Schema::dropIfExists('workshop_group_tutors');
    }

}
