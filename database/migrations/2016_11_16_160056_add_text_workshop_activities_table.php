<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTextWorkshopActivitiesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('workshop_activities', function(Blueprint $table) {
            $table->string('text', 4000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('workshop_activities', function(Blueprint $table) {
            $table->dropColumn('text');
        });
    }

}
