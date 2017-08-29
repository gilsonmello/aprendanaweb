<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestEnrollmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('enrollments', function(Blueprint $table) {
            $table->smallInteger('test')->default(0);
            $table->integer('user_id_created_by')->unsigned()->nullable();
            $table->foreign('user_id_created_by', 'fk_enrollments_user_id_created_by')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
