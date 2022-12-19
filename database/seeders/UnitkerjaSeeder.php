<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitkerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $unitKerja =[
            [
                'nama' => 'Admin',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'nama' => 'Pimpinan',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'nama' => 'Pengelola',
                'created_at' => null,
                'updated_at' => null,
            ],
        ];

        DB::table('unit_kerja')->insert($unitKerja);
    }
}
