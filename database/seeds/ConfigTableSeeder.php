<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class ConfigTableSeeder extends Seeder
{

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql')
            DB::table('configs')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('configs') . " CASCADE");

        //Add the master administrator, user id of 1
        $section = [
            [
                'email_contact_us' => 'adhemar.fontes@ipq.com.br',
                'pagseguro_token' => '',
                'pagseguro_email' => '',
                'facebook' => 'brasiljuridico',
                'twitter' => 'brasiljuridico',
                'youtube' => 'http://www.youtube.com/brasiljuridico',
                'instagram' => 'brasiljuridico',
                'smtp' => 'smtp.ipq.com.br',
                'smtp_user' => 'adhemar.fontes@ipq.com.br',
                'smtp_password' => '',
                'smtp_port' => '587',
                'percentage_count_video_view' => 60,
                'video_views' => 2,
                'percetage_share_teachers' => 35,
                'operational_cost' => 25,
                'taxes' => 15,
                'user_changed_id' => 1,
                'payment_fee' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('configs')->insert($section);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
