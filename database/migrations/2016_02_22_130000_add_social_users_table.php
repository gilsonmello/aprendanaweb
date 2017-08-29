<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function ($table) {
            $table->string('linkedin', 100)->nullable();
            $table->string('jusbrasil', 100)->nullable();
            $table->string('twitter', 100)->nullable();
            $table->string('periscope', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function ($table) {
            $table->dropColumn('linkedin');
            $table->dropColumn('jusbrasil');
            $table->dropColumn('twitter');
            $table->dropColumn('periscope');
        });
    }

}
