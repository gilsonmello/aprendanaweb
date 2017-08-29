<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTeacherstatementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('teacher_statements', function(Blueprint $table) {
            $table->foreign('user_teacher_id', 'fk_teacher_statements_user_teacher_id')->on('users')->references('id');
            $table->foreign('order_id', 'fk_teacher_statements_order_id')->on('orders')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('teacher_statements', function(Blueprint $table) {
            $table->dropForeign('fk_teacher_statements_user_teacher_id');
            $table->dropForeign('fk_teacher_statements_order_id');
        });
    }

}
