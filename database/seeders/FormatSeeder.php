<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $format =[
            [
                'nama' => 'FTETI',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'nama' => 'Jurusan Informatika',
                'created_at' => null,
                'updated_at' => null,
            ],
        ];

        DB::table('format')->insert($format);
    }
}
