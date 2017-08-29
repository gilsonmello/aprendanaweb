<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('order_status', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('orders', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('student_id')->unsigned()->nullable();
            $table->integer('coupon_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned();
            $table->dateTime('date_registration');
            $table->dateTime('date_confirmation')->nullable();
            $table->dateTime('date_cancel')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('student_id', 'fk_orders_student_id')->on('users')->references('id');
            $table->foreign('coupon_id', 'fk_orders_coupon_id')->on('coupons')->references('id');
            $table->foreign('status_id', 'fk_orders_status_id')->on('order_status')->references('id');
        });

        Schema::create('order_courses', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id', 'fk_order_courses_order_id')->on('orders')->references('id');
            $table->foreign('course_id', 'fk_order_courses_course_id')->on('courses')->references('id');
        });

        Schema::create('order_modules', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('module_id')->unsigned();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id', 'fk_order_modules_order_id')->on('orders')->references('id');
            $table->foreign('module_id', 'fk_order_modules_module_id')->on('modules')->references('id');
        });

        Schema::create('order_lessons', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('lesson_id')->unsigned();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id', 'fk_order_lessons_order_id')->on('orders')->references('id');
            $table->foreign('lesson_id', 'fk_order_lessons_lesson_id')->on('lessons')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('order_status');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_courses');
        Schema::dropIfExists('order_modules');
        Schema::dropIfExists('order_lessons');
    }

}
