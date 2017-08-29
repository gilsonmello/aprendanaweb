<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeyPreenrollmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('preenrollments', function (Blueprint $table) {
            $table->string('subscribe_key', 300)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('preenrollments', function ($table) {
            $table->dropColumn('subscribe_key');
        });
    }

}
