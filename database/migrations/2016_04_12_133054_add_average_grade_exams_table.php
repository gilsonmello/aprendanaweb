<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAverageGradeExamsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('exams', function(Blueprint $table) {
            $table->unsignedInteger('times_executed')->default(0);
            $table->double('average_grade')->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('exams', function(Blueprint $table) {
            $table->dropColumn('times_executed');
            $table->dropColumn('average_grade');
        });
    }

}
