<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUsersTable3 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function ($table) {
            $table->string('video', 100)->nullable();
            $table->string('youtube', 100)->nullable();
            $table->string('facebook', 100)->nullable();
            $table->string('instagram', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function ($table) {
            $table->dropColumn('video');
            $table->dropColumn('youtube');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
        });
    }

}
