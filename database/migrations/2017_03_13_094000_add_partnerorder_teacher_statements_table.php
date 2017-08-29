<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPartnerorderTeacherStatementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('teacher_statements', function(Blueprint $table) {
            $table->integer('partnerorder_id')->unsigned()->nullable();
            $table->integer('partnerorderpayment_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('teacher_statements',function(Blueprint $table){
            $table->dropColumn('partnerorder_id');
            $table->dropColumn('partnerorderpayment_id');
        });
    }

}
