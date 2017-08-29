<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatsCourses extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function ($table) {
            $table->decimal('average_grade', 4, 2)->nullable();
            $table->integer('orders_count')->nullable();
            $table->char('special_offer', 1)->nullable();
            $table->char('featured', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('courses', function ($table) {
            $table->dropColumn('average_grade');
            $table->dropColumn('orders_count');
            $table->dropColumn('special_offer');
        });
    }

}
