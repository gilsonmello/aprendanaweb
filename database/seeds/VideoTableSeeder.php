<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class VideoTableSeeder extends Seeder
{

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql')
            DB::table('videos')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('videos') . " CASCADE");

        //Add the master administrator, user id of 1
        $video = [
            [
                'title' => 'Mudanças na Legislação eleitoral brasileira',
                'slug' => 'mudancas-na-legislacao-eleitoral-brasileira',
                'url' => 'https://www.youtube.com/watch?v=_1nhWeIRvG0',
                'content' => '<p>No dia 29 de setembro foi aprovada a <b>Lei 13.165/15</b>, que estabeleceu mudanças na Legislação eleitoral brasileira. Assista o Curta Jurídico do nosso professor Jaime Barreiros Neto e confira as principais alterações.<br></p>',
                'tags' => 'Tag 2;Tag_3',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'activation_date' => Carbon::now(),
            ]
        ];

        DB::table('videos')->insert($video);


        //Add the master administrator, user id of 1
        $video = [
            [
                'title' => 'Desapropriação urbanística e agrária',
                'slug' => 'desapropriacao-urbanistica-e-agraria',
                'url' => 'https://www.youtube.com/watch?v=399hrqebHmY',
                'content' => '<p>O curta de hoje aborda um tema muito corriqueiro em concursos de advocacia pública, você sabe por que a desapropriação urbanística e agrária se distingue da desapropriação ordinária? O professor Georges Humbert explica.<br></p>',
                'tags' => 'Tag1',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'activation_date' => Carbon::now(),
            ]
        ];

        DB::table('videos')->insert($video);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}



