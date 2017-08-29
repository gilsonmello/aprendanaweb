<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleTeachersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('module_teachers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->foreign('module_id', 'fk_module_teachers_1')->on('modules')->references('id');
            $table->foreign('teacher_id', 'fk_module_teachers_2')->on('users')->references('id');
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
        Schema::dropIfExists('module_teachers');
    }

}
