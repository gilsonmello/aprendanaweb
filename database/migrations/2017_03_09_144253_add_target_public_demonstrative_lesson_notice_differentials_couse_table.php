<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTargetPublicDemonstrativeLessonNoticeDifferentialsCouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function(Blueprint $table) {
            $table->longText('target_public')->nullable();
            $table->string('demonstrative_lesson', 255)->nullable();
            $table->string('notice', 255)->nullable();
            $table->longText('differentials')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function(Blueprint $table) {
            $table->dropColumn('target_public');
            $table->dropColumn('demonstrative_lesson');
            $table->dropColumn('notice');
            $table->dropColumn('differentials');
        });
    }
}
