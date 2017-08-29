<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('courses', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('subsection_id')->unsigned()->nullable()->index('fk_courses_1_idx');
            $table->integer('user_admin_id')->unsigned()->nullable();
            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->text('course_content')->nullable();
            $table->string('slug', 200)->nullable();
            $table->string('tags', 1000)->nullable();
            $table->string('video_ad_url', 300)->nullable();
            $table->dateTime('activation_date')->nullable();
            $table->decimal('price', 10)->nullable();
            $table->decimal('discount_price', 10)->nullable();
            $table->string('featured_img', 100)->nullable();
            $table->boolean('is_active')->nullable();
            $table->decimal('teachers_percentage', 5)->nullable();
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
        Schema::dropIfExists('courses');
    }

}
