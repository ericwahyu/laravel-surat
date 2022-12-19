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
                'nama' => 'Fakultas Teknologi Elekro dan Teknologi Informasi',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'nama' => 'Jurusan Teknik Informatika',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'nama' => 'Jurusan Sistem Informasi',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'nama' => 'Jurusan Teknik Elektro',
                'created_at' => null,
                'updated_at' => null,
            ],
        ];

        DB::table('format')->insert($format);
    }
}
