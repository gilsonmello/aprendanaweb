<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyNotificationUser extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('notification_user', function(Blueprint $table) {
            $table->foreign('notification_message_id', 'fk_notification_message_id')->on('notification_message')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('notification_user', function(Blueprint $table) {
            $table->dropForeign('fk_notification_message_id');
        });
    }

}
