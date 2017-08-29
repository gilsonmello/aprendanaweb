<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalysisTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('analysis_exam_groups', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('analysis', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->text('intro_text')->nullable();
            $table->string('intro_page', 200)->nullable();
            $table->text('conclusion_text')->nullable();

            $table->integer('subject_id')->unsigned()->nullable();
            $table->foreign('subject_id', 'fk_analysis_subject_id')->on('subjects')->references('id');

            $table->integer('analysis_exam_group_id')->unsigned()->nullable();
            $table->foreign('analysis_exam_group_id', 'fk_analysis_analysis_exam_group_id')->on('analysis_exam_groups')->references('id');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('analysis_subjects', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id', 'fk_analysis_subjects_subject_id')->on('subjects')->references('id');

            $table->integer('analysis_id')->unsigned();
            $table->foreign('analysis_id', 'fk_analysis_subjects_analysis_id')->on('analysis')->references('id');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('analysis_exams', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->string('acronym', 20);
            $table->boolean('is_active')->default(0);
            $table->date('date');
            $table->date('date_result');

            $table->integer('source_id')->unsigned()->nullable();
            $table->foreign('source_id', 'fk_analysis_exams_source_id')->on('sources')->references('id');

            $table->integer('office_id')->unsigned()->nullable();
            $table->foreign('office_id', 'fk_analysis_exams_office_id')->on('offices')->references('id');

            $table->integer('institution_id')->unsigned()->nullable();
            $table->foreign('institution_id', 'fk_analysis_exams_institution_id')->on('institutions')->references('id');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('analysis_exams_groups', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('analysis_exam_group_id')->unsigned();
            $table->foreign('analysis_exam_group_id', 'fk_analysis_exams_groups_analysis_exam_group_id')->on('analysis_exam_groups')->references('id');

            $table->integer('analysis_exam_id')->unsigned();
            $table->foreign('analysis_exam_id', 'fk_analysis_exams_groups_analysis_exam_id')->on('analysis_exams')->references('id');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('analysis_exam_subjects', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('analysis_exam_id')->unsigned();
            $table->foreign('analysis_exam_id', 'fk_analysis_exam_subjects_analysis_exam_id')->on('analysis_exams')->references('id');

            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id', 'fk_analysis_exam_subjects_subject_id')->on('subjects')->references('id');

            $table->integer('count')->unsigned();

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
