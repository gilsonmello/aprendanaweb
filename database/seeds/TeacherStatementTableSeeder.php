<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class TeacherStatementTableSeeder extends Seeder
{

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql')
            DB::table('teacher_statements')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('teacher_statements') . " CASCADE");

        //Add the master administrator, user id of 1
        $statement = [
            [
			'user_teacher_id'=> 2,
			'buyer_name'=> 'Adhemar de Souza Fontes Neto',
			'order_id'=> 2,
			'product_name' => 'Curso Preparatório para Procurador do Município de Salvador',
			'date'=> Carbon::now(),
			'date_order'=> Carbon::now(),
			'value_order'=> 1000,
			'value_discount'=> 200,
			'value_order_final'=> 800,
			'value_payment_tax'=> 60,
			'value_taxes'=> 40,
			'value_costs'=> 200,
            'value_net' => 500,
            'percentage_distribute' => 35,
            'value_distribute'=> 175,
			'value_distribute'=> 175,
			'percentage'=> 10,
			'value'=> 17.5
                
            ]
        ];

        DB::table('teacher_statements')->insert($statement);

        //Add the master administrator, user id of 1
        $statement = [
            [
                'user_teacher_id'=> 2,
                'buyer_name'=> 'Adhemar de Souza Fontes Neto',
                'order_id'=> 2,
                'product_name' => 'Novo CPC',
                'date'=> Carbon::now(),
                'date_order'=> Carbon::now(),
                'value_order'=> 400,
                'value_discount'=> 100,
                'value_order_final'=> 300,
                'value_payment_tax'=> 30,
                'value_taxes'=> 20,
                'value_costs'=> 50,
                'value_net' => 200,
                'percentage_distribute' => 40,
                'value_distribute'=> 80,
                'percentage'=> 100,
                'value'=> 80

            ]
        ];

        DB::table('teacher_statements')->insert($statement);

        //Add the master administrator, user id of 1
        $statement = [
            [
                'user_teacher_id'=> 2,
                'buyer_name'=> 'Fernanda Taboada Fontes',
                'order_id'=> null,
                'product_name' => null,
                'date'=> Carbon::now(),
                'date_order'=> null,
                'value_order'=> null,
                'value_discount'=> null,
                'value_order_final'=> null,
                'value_payment_tax'=> null,
                'value_taxes'=> null,
                'value_costs'=> null,
                'value_net' => null,
                'percentage_distribute' => null,
                'value_distribute'=> null,
                'percentage'=> null,
                'value'=> -50

            ]
        ];

        DB::table('teacher_statements')->insert($statement);

        //Add the master administrator, user id of 1
        $statement = [
            [
                'user_teacher_id'=> 2,
                'buyer_name'=> 'Adhemar de Souza Fontes Neto',
                'order_id'=> 1,
                'product_name' => 'Novo CPC',
                'date'=> Carbon::now(),
                'date_order'=> Carbon::now(),
                'value_order'=> 400,
                'value_discount'=> 100,
                'value_order_final'=> 300,
                'value_payment_tax'=> 30,
                'value_taxes'=> 20,
                'value_costs'=> 50,
                'value_net' => 200,
                'percentage_distribute' => 40,
                'value_distribute'=> 80,
                'percentage'=> 100,
                'value'=> 80

            ]
        ];

        DB::table('teacher_statements')->insert($statement);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
