<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnrollmentForeignRatingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('ratings', function(Blueprint $table) {
            $table->integer('enrollment_id')->unsigned()->nullable();
            $table->foreign('enrollment_id', 'fk_enrollment_ratings_id')->on('enrollments')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('ratings', function(Blueprint $table) {
            $table->dropForeign('fk_enrollment_ratings_id');
            $table->dropColumn('enrollment_id');
        });
    }

}
