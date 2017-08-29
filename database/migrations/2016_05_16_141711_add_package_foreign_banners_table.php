<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackageForeignBannersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('banners', function(Blueprint $table) {
            $table->integer('package_id')->unsigned()->nullable();
            $table->foreign('package_id', 'fk_banners_package_id')->on('packages')->references('id');
            $table->dropForeign('fk_banners_exam_id');
            $table->dropColumn('exam_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('banners', function(Blueprint $table) {
            $table->dropForeign('fk_banners_package_id');
            $table->dropColumn('package_id');
            $table->integer('exam_id')->unsigned()->nullable();
            $table->foreign('exam_id', 'fk_banners_exam_id')->on('exams')->references('id');
        });
    }

}
