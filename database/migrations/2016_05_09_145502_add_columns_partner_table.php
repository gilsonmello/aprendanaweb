<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPartnerTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('logo', 200)->nullable();
            $table->integer('days_subscribe')->default(10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('partners', function ($table) {
            $table->dropColumn('logo');
            $table->dropColumn('days_subscribe');
        });
    }

}
