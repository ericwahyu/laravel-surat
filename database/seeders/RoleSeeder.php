<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role =[
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

        DB::table('role')->insert($role);
    }
}
