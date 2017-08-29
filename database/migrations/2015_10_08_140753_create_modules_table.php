<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('modules', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('description', 250)->nullable();
            $table->decimal('price', 11)->nullable();
            $table->integer('subsection_id')->nullable();
            $table->string('video_ad_url')->nullable();
            $table->integer('sequence')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('tags')->nullable();
            $table->boolean('is_sold_separately');
            $table->dateTime('activation_date')->nullable();
            $table->decimal('discount_price', 10)->nullable();
            $table->string('featured_img', 250)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('modules');
    }

}
