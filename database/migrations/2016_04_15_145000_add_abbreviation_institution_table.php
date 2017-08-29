<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAbbreviationInstitutionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('institutions', function (Blueprint $table) {
            $table->string('abbreviation', 15)->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('institutions', function ($table) {
            $table->dropColumn('abbreviation');
        });
    }

}
