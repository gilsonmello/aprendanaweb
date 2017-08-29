<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('configs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('email_contact_us', 100)->nullable();
            $table->string('pagseguro_token', 255)->nullable();
            $table->string('pagseguro_email', 255)->nullable();
            $table->string('facebook', 50)->nullable();
            $table->string('twitter', 50)->nullable();
            $table->string('youtube', 50)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('smtp', 100)->nullable();
            $table->string('smtp_user', 100)->nullable();
            $table->string('smtp_password', 100)->nullable();
            $table->string('smtp_port', 100)->nullable();
            $table->smallInteger('percentage_count_video_view')->unsigned();
            $table->smallInteger('video_views')->unsigned();
            $table->smallInteger('percetage_share_teachers')->unsigned();
            $table->double('operational_cost');
            $table->integer('user_changed_id')->unsigned();
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
        Schema::dropIfExists('configs');
    }

}
