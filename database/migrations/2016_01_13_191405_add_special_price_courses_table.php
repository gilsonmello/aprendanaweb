<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpecialPriceCoursesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function ($table) {
            $table->dateTime('start_special_price')->nullable();
            $table->dateTime('end_special_price')->nullable();
            $table->decimal('special_price', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('courses', function ($table) {
            $table->dropColumn('start_special_price');
            $table->dropColumn('end_special_price');
            $table->dropColumn('special_price');
        });
    }

}
