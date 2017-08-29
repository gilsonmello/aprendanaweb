<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactions extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transactions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id'); //reference
            $table->string('payment_hub'); // fixo - 'pagseguro'
            $table->string('payment_id'); // code
            $table->integer('payment_method'); // paymentMethod -> type
            $table->integer('payment_code'); // paymentMethod -> code
            $table->decimal('installment_fee_amount', 7, 2)->nullable(); // installmentFeeAmount
            $table->integer('installment_count'); //installmentCount
            $table->decimal('discount_amount', 7, 2); //discountAmount
            $table->decimal('gross_amount', 7, 2); //grossAmount
            $table->integer('net_amount'); //netAmount
            $table->decimal('operational_fee_amount', 7, 2)->nullable(); // operationalFeeAmount
            $table->decimal('intermediation_fee_amount', 7, 2)->nullable(); //intermediationFeeAmount
            $table->decimal('intermediation_fee_rate', 7, 2)->nullable(); // intermediationRateAmount
            $table->dateTimeTz('escrow_date'); // escrowEndDate
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
        Schema::dropIfExists('transactions');
    }

}
