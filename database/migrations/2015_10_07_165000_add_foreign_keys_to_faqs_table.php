<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFaqsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('faqs', function(Blueprint $table) {
            $table->foreign('category_faq_id', 'fk_faqs_1')->on('faqcategory')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('faqs', function(Blueprint $table) {
            $table->dropForeign('fk_faqs_1');
        });
    }

}
