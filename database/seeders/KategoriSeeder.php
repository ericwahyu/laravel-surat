<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $kategori =[
            [
                'nama' => 'surat masuk',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'nama' => 'surat keluar',
                'created_at' => null,
                'updated_at' => null,
            ],

        ];

        DB::table('kategori')->insert($kategori);

    }
}
