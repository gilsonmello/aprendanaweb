<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContactFoneCityStateCountrySuppliersTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
                Schema::table('suppliers', function(Blueprint $table) {
                        $table->string('contact', 45)->nullable()->change();
                        $table->string('fone', 15)->nullable()->change();
                        $table->integer('city')->nullable()->change();
                        $table->integer('state')->nullable()->change();
                        $table->integer('country')->nullable()->change();
                });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
//                $table->string('contact', 45)->nullable()->change();
//                $table->string('fone', 15)->nullable()->change();
//                $table->integer('city')->nullable()->change();
//                $table->integer('state')->nullable()->change();
//                $table->integer('country')->nullable()->change();
        }

}
