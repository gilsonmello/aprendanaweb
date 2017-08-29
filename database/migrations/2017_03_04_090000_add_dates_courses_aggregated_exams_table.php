<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatesCoursesAggregatedExamsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses_aggregated_exams', function(Blueprint $table) {
            $table->datetime('date_begin')->nullable();
            $table->datetime('days_begin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('courses_aggregated_exams',function(Blueprint $table){
            $table->dropColumn('date_begin');
            $table->dropColumn('days_begin');
        });

    }

}
