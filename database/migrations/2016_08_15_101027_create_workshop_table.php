<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('workshops', function(Blueprint $table) {
            $table->increments('id');
            $table->string('description', 200);
            $table->string('content', 4000);
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id', 'fk_workshops_course_id')->on('courses')->references('id');
            $table->smallInteger('available_days_after_enrollment')->nullable();
            $table->date('available_date')->nullable();
            $table->float('minimum_grade')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('workshop_criterias', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workshop_id')->unsigned()->nullable();
            $table->foreign('workshop_id', 'fk_workshop_criterias_workshop')->on('workshops')->references('id');
            $table->string('description', 100);
            $table->string('explanation', 2000);
            $table->float('max_grade')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('workshop_activities', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workshop_id')->unsigned()->nullable();
            $table->foreign('workshop_id', 'fk_workshop_activities_workshop')->on('workshops')->references('id');
            $table->string('description', 1000);
            $table->string('url_document', 300);
            $table->string('url_response', 300);
            $table->longText('text_response');
            $table->float('minimum_grade')->nullable();
            $table->smallInteger('available_days_after_workshop')->nullable();
            $table->date('available_date')->nullable();
            $table->smallInteger('submit_deadline_days')->nullable();
            $table->date('submit_deadline_date')->nullable();
            $table->smallInteger('evaluation_deadline_days')->nullable();
            $table->date('evaluation_deadline_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('workshop_tutors', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workshop_id')->unsigned()->nullable();
            $table->foreign('workshop_id', 'fk_workshop_tutors_workshop')->on('workshops')->references('id');
            $table->integer('criteria_id')->unsigned()->nullable();
            $table->foreign('criteria_id', 'fk_workshop_tutors_criteria')->on('workshop_criterias')->references('id');
            $table->integer('tutor_id')->unsigned()->nullable();
            $table->foreign('tutor_id', 'fk_workshop_tutors_tutor')->on('users')->references('id');
            $table->smallInteger('position')->nullable();
            $table->smallInteger('max_students')->nullable();
            $table->smallInteger('num_students')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('my_workshop_tutors', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workshop_id')->unsigned()->nullable();
            $table->foreign('workshop_id', 'fk_my_workshop_tutors_workshop')->on('workshops')->references('id');
            $table->integer('criteria_id')->unsigned()->nullable();
            $table->foreign('criteria_id', 'fk_my_workshop_tutors_criteria')->on('workshop_criterias')->references('id');
            $table->integer('tutor_id')->unsigned()->nullable();
            $table->foreign('tutor_id', 'fk_my_workshop_tutors_tutor')->on('users')->references('id');
            $table->integer('enrollment_id')->unsigned()->nullable();
            $table->foreign('enrollment_id', 'fk_my_workshop_tutors_enrollment')->on('enrollments')->references('id');
            $table->smallInteger('deadline_days_after_submit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('my_workshop_activities', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workshop_id')->unsigned()->nullable();
            $table->foreign('workshop_id', 'fk_my_workshop_activities_workshop')->on('workshops')->references('id');
            $table->integer('activity_id')->unsigned()->nullable();
            $table->foreign('activity_id', 'fk_my_workshop_activities_activity')->on('workshop_activities')->references('id');
            $table->integer('enrollment_id')->unsigned()->nullable();
            $table->foreign('enrollment_id', 'fk_my_workshop_activities_enrollment')->on('enrollments')->references('id');
            $table->date('date_submit')->nullable();
            $table->string('url_document_activity', 300);
            $table->boolean('reference')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('my_workshop_evaluations', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('my_activity_id')->unsigned()->nullable();
            $table->foreign('my_activity_id', 'fk_my_workshop_evaluations_my_activity')->on('my_workshop_activities')->references('id');
            $table->integer('tutor_id')->unsigned()->nullable();
            $table->foreign('tutor_id', 'fk_my_workshop_evaluations_tutor')->on('users')->references('id');
            $table->integer('criteria_id')->unsigned()->nullable();
            $table->foreign('criteria_id', 'fk_my_workshop_evaluations_criteria')->on('workshop_activities')->references('id');
            $table->date('date_deadline')->nullable();
            $table->date('date_evaluation')->nullable();
            $table->string('url_evaluation', 300);
            $table->string('evaluation', 5000)->nullable();
            $table->float('grade')->nullable();
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
        Schema::dropIfExists('workshops');
        Schema::dropIfExists('workshop_criterias');
        Schema::dropIfExists('workshop_activities');
        Schema::dropIfExists('workshop_tutors');
        Schema::dropIfExists('my_workshop_tutors');
        Schema::dropIfExists('my_workshop_activities');
        Schema::dropIfExists('my_workshop_evaluations');
    }

}
