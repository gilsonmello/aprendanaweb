<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageTeachersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('package_teachers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('package_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->foreign('package_id', 'fk_package_teachers_1')->on('packages')->references('id');
            $table->foreign('teacher_id', 'fk_package_teachers_2')->on('users')->references('id');
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
        Schema::dropIfExists('package_teachers');
    }

}
