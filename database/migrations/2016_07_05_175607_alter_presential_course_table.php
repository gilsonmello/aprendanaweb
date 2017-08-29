<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPresentialCourseTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('courses', function(Blueprint $table) {
            $table->text('methodology')->nullable();
            $table->string('payment', 500)->nullable();
            $table->decimal('workload', 10, 2)->nullable()->change();
            $table->decimal('workload_presential', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('courses', function(Blueprint $table) {
            $table->dropColumn('methodology');
            $table->dropColumn('payment');
            $table->integer('workload')->nullable()->change();
            $table->dropColumn('workload_presential');
        });
    }

}
