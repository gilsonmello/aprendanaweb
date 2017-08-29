<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //Add the master administrator, user id of 1
        $suppliers = [
            [
                'id' => 1,
                'company_name' => 'BRASIL JURÍDICO',
                'contact' => 'Informe a pessoa de contato',
                'fone' => '7199999999',
                'city' => 'SALVADOR',
                'state' => 'BAHIA',
                'country' => 'BRASIL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('suppliers')->insert($suppliers);
    }

}
