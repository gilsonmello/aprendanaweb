<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCoursesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function(Blueprint $table) {
            $table->foreign('subsection_id', 'fk_courses_1')->on('subsections')->references('id');
            $table->foreign('user_admin_id', 'fk_courses_2')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('courses', function(Blueprint $table) {
            $table->dropForeign('fk_courses_1');
            $table->dropForeign('fk_courses_2');
        });
    }

}
