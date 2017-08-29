<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepresentativeCommissionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('representative_commissions', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('representative_id')->unsigned();
            $table->integer('period_type');
            $table->decimal('range_begin', 9, 2);
            $table->decimal('range_end', 9, 2);
            $table->decimal('commission_percentage', 5, 2)->nullable();
            $table->dateTime('date_begin');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('representative_id', 'fk_representative_commissions_representative_id')->on('users')->references('id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('representative_commissions');
    }

}
