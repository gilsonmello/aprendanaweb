<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDomainForeignNewsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('news', function(Blueprint $table) {
            $table->integer('domain_id')->unsigned()->nullable();
            $table->foreign('domain_id', 'fk_news_domain_id')->on('workshop_activities')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('news', function(Blueprint $table) {
            $table->dropForeign('fk_news_domain_id');
            $table->dropColumn('domain_id');
        });
    }

}
