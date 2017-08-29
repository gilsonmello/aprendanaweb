<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsSectionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sections', function (Blueprint $table) {
            $table->integer('sequence')->default(1);
            $table->boolean('active')->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sections', function ($table) {
            $table->dropColumn('sequence');
            $table->dropColumn('active');
        });
    }

}
