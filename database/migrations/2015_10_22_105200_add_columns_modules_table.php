<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsModulesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('modules', function ($table) {
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id', 'fk_module_course_id')->on('courses')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('modules', function ($table) {
            $table->dropColumn('course_id');
            $table->dropColumn('access_time');
            $table->dropColumn('workload');
        });
    }

}
