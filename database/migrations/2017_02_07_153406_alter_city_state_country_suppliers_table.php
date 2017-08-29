<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCityStateCountrySuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function(Blueprint $table) {
            $table->renameColumn('city', 'city_id');
            $table->renameColumn('state', 'state_id');
            $table->renameColumn('country', 'country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->renameColumn('city_id', 'city');
        $table->renameColumn('state_id', 'state');
        $table->renameColumn('country_id', 'country');
    }
}
