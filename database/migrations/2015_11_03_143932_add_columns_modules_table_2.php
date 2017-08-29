
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsModulesTable2 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('modules', function ($table) {
            $table->integer('access_time')->unsigned()->nullable();
            $table->integer('workload')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('modules', function ($table) {
            $table->dropColumn('access_time');
            $table->dropColumn('workload');
        });
    }

}
