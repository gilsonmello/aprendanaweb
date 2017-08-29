<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function(Blueprint $table) {
            $table->string('title', 255);
            $table->string('img', 255);
            $table->dropColumn('featured');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function(Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('img');
        });
    }

}
