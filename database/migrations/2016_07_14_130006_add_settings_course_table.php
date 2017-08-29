<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsCourseTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function(Blueprint $table) {
            $table->boolean('show_files')->default(1);
            $table->boolean('show_alert')->default(1);
            $table->boolean('show_calendar')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('courses', function(Blueprint $table) {
            $table->dropIfExists('show_files');
            $table->dropIfExists('show_alert');
            $table->dropIfExists('show_calendar');
        });
    }

}
