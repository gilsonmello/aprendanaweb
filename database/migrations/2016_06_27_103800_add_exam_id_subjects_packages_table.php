<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExamIdSubjectsPackagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('subjects_packages', function(Blueprint $table) {
            $table->unsignedInteger('exam_id');
            $table->foreign('exam_id', 'fk_exam_subjects_packages_id')->references('id')->on('exams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('subjects_packages', function(Blueprint $table) {
            $table->dropForeign('fk_exam_subjects_packages_id');
            $table->dropColumn('exam_id');
        });
    }

}
