<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubsectionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('subsections', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('subsections');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
