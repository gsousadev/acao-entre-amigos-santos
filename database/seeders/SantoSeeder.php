<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SantoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static function run(): void
    {

        $santos = json_decode(file_get_contents("./informacoes_santos.json"));

        foreach ($santos as $santo) {
            DB::table('santos')->insert([
                'nome' => data_get($santo, 'nome'),
                'slug' => data_get($santo, 'slug'),
                'imagem' => data_get($santo, 'imagem')
            ]);
        }
    }
}
