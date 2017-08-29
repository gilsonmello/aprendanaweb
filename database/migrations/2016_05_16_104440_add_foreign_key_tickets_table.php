<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyTicketsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('tickets', function(Blueprint $table) {
            $table->integer('content_id')->unsigned()->nullable();
            $table->foreign('content_id', 'fk_tickets_content_id')->on('contents')->references('id');

            $table->integer('enrollment_id')->unsigned()->nullable();
            $table->foreign('enrollment_id', 'fk_tickets_enrollment_id')->on('enrollments')->references('id');
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
