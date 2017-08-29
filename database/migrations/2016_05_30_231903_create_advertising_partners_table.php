<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisingPartnersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('advertising_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('contact', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('source', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('partners', function ($table) {
            $table->dropColumn('source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('partners');
    }

}
