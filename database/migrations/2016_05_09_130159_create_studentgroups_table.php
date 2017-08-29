<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentgroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('studentgroups', function(Blueprint $table) {
            $table->increments('id');

            $table->text('name', 40);
            $table->integer('partner_id')->unsigned()->nullable();
            $table->foreign('partner_id', 'fk_studentgroups_partner_id')->references('id')->on('partners');
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
        Schema::dropIfExists('studentgroups');
    }

}
