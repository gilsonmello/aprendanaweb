<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsSectorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sectors', function ($table) {
            $table->smallInteger('hours_to_reply');
            $table->string('message_finish', 2000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sectors', function (Blueprint $table) {
            $table->dropColumn('hours_to_reply');
            $table->dropColumn('message_finish');
        });
    }

}
