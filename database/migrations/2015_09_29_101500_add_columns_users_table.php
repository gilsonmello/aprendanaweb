<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function ($table) {
            $table->string('photo', 255)->nullable();
            $table->string('cel', 20)->nullable();
            $table->string('personal_id', 20)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('professional_number', 20)->nullable();
            $table->string('bank', 10)->nullable();
            $table->string('agency', 10)->nullable();
            $table->string('account', 15)->nullable();
            $table->string('tags', 1000)->nullable();
            $table->string('neighborhood', 100)->nullable();
            $table->integer('city_id')->nullable()->unsigned();
            $table->string('zip', 15)->nullable();
            $table->string('address_number', 10)->nullable();
            $table->string('address_comp', 100)->nullable();
            $table->tinyInteger('is_newsletter_subscriber')->nullable();
            $table->char('gender', 1)->nullable();
            $table->date('birthdate')->nullable();
            $table->datetime('last_access')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function ($table) {
            $table->dropColumn('photo');
            $table->dropColumn('cel');
            $table->dropColumn('personal_id');
            $table->dropColumn('address');
            $table->dropColumn('professional_number');
            $table->dropColumn('bank');
            $table->dropColumn('agency');
            $table->dropColumn('account');
            $table->dropColumn('tags');
            $table->dropColumn('neighborhood');
            $table->dropColumn('city_id');
            $table->dropColumn('zip');
            $table->dropColumn('address_number');
            $table->dropColumn('address_comp');
            $table->dropColumn('is_newsletter_subscriber');
            $table->dropColumn('gender');
            $table->dropColumn('birthdate');
            $table->dropColumn('last_access');
        });
    }

}
