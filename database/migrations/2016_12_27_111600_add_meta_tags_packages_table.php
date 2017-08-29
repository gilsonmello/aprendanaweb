<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaTagsPackagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('packages', function(Blueprint $table) {
            $table->text('meta_description')->nullable();
            $table->text('meta_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('packages', function(Blueprint $table) {
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_title');
        });
    }

}
