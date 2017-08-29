<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeacherStatementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('teacher_statements', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_teacher_id')->unsigned();
            $table->integer('order_id')->unsigned()->nullable();
            $table->string('buyer_name', 200)->nullable();
            $table->string('product_name', 200)->nullable();
            $table->dateTime('date');
            $table->dateTime('date_order')->nullable();
            $table->decimal('value_order', 8, 2)->nullable();
            $table->decimal('value_discount', 8, 2)->nullable();
            $table->decimal('value_order_final', 8, 2)->nullable();
            $table->decimal('value_payment_tax', 8, 2)->nullable();
            $table->decimal('value_taxes', 8, 2)->nullable();
            $table->decimal('value_costs', 8, 2)->nullable();
            $table->decimal('value_net', 8, 2)->nullable();
            $table->decimal('percentage_distribute', 5, 2)->nullable();
            $table->decimal('value_distribute', 8, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->decimal('value', 8, 2);
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
        Schema::dropIfExists('teacher_statements');
    }

}
