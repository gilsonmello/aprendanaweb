<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBannersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('banners', function(Blueprint $table) {
            $table->integer('is_active')->default(0);
            $table->integer('order');
            $table->integer('carousel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('banners', function(Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('order');
            $table->dropColumn('carousel');
        });
    }

}
