<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComplementaryModuleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('modules', function(Blueprint $table) {
            $table->boolean('complementary')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('modules', function(Blueprint $table) {
            $table->dropIfExists('complementary');
        });
    }

}
