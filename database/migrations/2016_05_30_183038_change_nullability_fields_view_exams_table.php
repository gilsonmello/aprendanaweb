<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullabilityFieldsViewExamsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('view_exams', function(Blueprint $table) {
            $table->integer('enrollment_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('view_exams', function(Blueprint $table) {
            $table->integer('enrollment_id')->unsigned()->change();
        });
    }

}
