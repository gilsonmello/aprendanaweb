<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTitleBooksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('books', function(Blueprint $table) {
            $table->dropColumn('title');
            $table->renameColumn('products_id', 'product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('books', function(Blueprint $table) {
            $table->string('title', 255);
            $table->renameColumn( 'product_id', 'products_id');
        });
    }

}
