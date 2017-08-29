<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSearchPackages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement('ALTER TABLE packages DROP INDEX search;');
        DB::statement('ALTER TABLE packages ADD FULLTEXT search(title, description,tags)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('ALTER TABLE packages DROP INDEX search;');
        DB::statement('ALTER TABLE packages ADD FULLTEXT search(title, description)');
    }

}
