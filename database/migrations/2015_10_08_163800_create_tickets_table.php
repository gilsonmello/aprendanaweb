<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tickets', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_student_id')->unsigned();
            $table->integer('sector_id')->unsigned();
            $table->text('message', 1000);
            $table->Timestamp('date_dead_line_reply');
            $table->smallInteger('is_replied');
            $table->smallInteger('is_finished');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('tickets');
    }

}
