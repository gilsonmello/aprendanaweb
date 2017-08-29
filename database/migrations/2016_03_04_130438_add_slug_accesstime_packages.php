<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugAccesstimePackages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('packages', function(Blueprint $table) {
            $table->string('slug', 200)->nullable();
            $table->integer('access_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('packages', function(Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('access_time');
        });
    }

}
