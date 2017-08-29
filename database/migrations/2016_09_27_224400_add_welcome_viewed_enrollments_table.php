<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWelcomeViewedEnrollmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('enrollments', function ($table) {
            $table->boolean('welcome_viewed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('enrollments', function ($table) {
            $table->dropColumn('welcome_viewed');
        });
    }

}
