<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignSubjectsPackagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('subjects_packages', function(Blueprint $table) {
            $table->foreign('subject_id', 'fk_subject_package_relation_id')->references('id')->on('subjects');
            //  $table->foreign('package_id','fk_package_subject_relation_id')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('subjects_packages', function(Blueprint $table) {
            $table->dropForeign('fk_subject_package_relation_id');
            //  $table->dropForeign('fk_package_subject_relation_id');
        });
    }

}
