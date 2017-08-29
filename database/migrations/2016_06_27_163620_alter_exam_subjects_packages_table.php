<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExamSubjectsPackagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('subjects_packages', function(Blueprint $table) {
            $table->unsignedInteger('exam_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('subjects_packages', function(Blueprint $table) {
            $table->unsignedInteger('exam_id')->change();
        });
    }

}
