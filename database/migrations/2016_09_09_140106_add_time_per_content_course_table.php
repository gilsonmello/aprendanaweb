<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimePerContentCourseTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function(Blueprint $table) {
            $table->string('time_per_content', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('courses', function(Blueprint $table) {
            $table->dropIfExists('time_per_content');
        });
    }

}
