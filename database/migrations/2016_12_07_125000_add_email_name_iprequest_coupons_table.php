<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailNameIprequestCouponsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('coupons', function ($table) {
            $table->string('email', 200)->nullable();
            $table->string('name_student', 100)->nullable();
            $table->string('ip_request', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('coupons', function ($table) {
            $table->dropColumn('email');
            $table->dropColumn('name_student');
            $table->dropColumn('ip_request');
        });
    }

}
