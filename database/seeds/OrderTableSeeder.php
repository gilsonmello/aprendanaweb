<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class OrderTableSeeder extends Seeder
{

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql')
            DB::table('order_status')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('order_status') . " CASCADE");

        if (env('DB_DRIVER') == 'mysql')
            DB::table('orders')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('orders') . " CASCADE");

        if (env('DB_DRIVER') == 'mysql')
            DB::table('order_courses')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('order_courses') . " CASCADE");

        if (env('DB_DRIVER') == 'mysql')
            DB::table('order_modules')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('order_modules') . " CASCADE");

        if (env('DB_DRIVER') == 'mysql')
            DB::table('order_lessons')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('order_lessons') . " CASCADE");

        $status = [['name'=> 'Pendente de conclusão',]]; DB::table('order_status')->insert($status);
        $status = [['name'=> 'Pendente de pagamento',]]; DB::table('order_status')->insert($status);
        $status = [['name'=> 'Pagamento confirmado',]]; DB::table('order_status')->insert($status);
        $status = [['name'=> 'Liberado',]]; DB::table('order_status')->insert($status);
        $status = [['name'=> 'Cancelado',]]; DB::table('order_status')->insert($status);

        //Add the master administrator, user id of 1
        $order = [
            [
                'student_id'=> 4,
                'status_id'=> 4,
                'date_registration'=> Carbon::now(),
                'date_confirmation'=> Carbon::now(),
                'price'=> 1000,
                'discount_price'=> 800,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]
        ];

        DB::table('orders')->insert($order);

        //Add the master administrator, user id of 1
        $order_course = [
            [
                'order_id'=> 1,
                'course_id'=> 1,
                'price'=> 1000,
                'discount_price'=> 800,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('order_courses')->insert($order_course);

        //Add the master administrator, user id of 1
        $order = [
            [
                'student_id'=> 5,
                'status_id'=> 4,
                'date_registration'=> Carbon::now(),
                'date_confirmation'=> Carbon::now(),
                'price'=> 300,
                'discount_price'=> 270,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]
        ];

        DB::table('orders')->insert($order);

        //Add the master administrator, user id of 1
        $order_course = [
            [
                'order_id'=> 1,
                'course_id'=> 1,
                'price'=> 300,
                'discount_price'=> 270,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('order_courses')->insert($order_course);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
