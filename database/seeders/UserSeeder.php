<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user =[
            [
                'username' => 'eric',
                'email' => 'eric@gmail.com',
                'password' => '$2a$12$LJnFNEBXPnO1KB2WSGapBO7YzbI8oRyQiHR5W9GT3.LY0sAvUU4VO',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'username' => 'wahyu',
                'email' => 'wahyu@gmail.com',
                'password' => '$2a$12$LJnFNEBXPnO1KB2WSGapBO7YzbI8oRyQiHR5W9GT3.LY0sAvUU4VO',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'username' => 'amir',
                'email' => 'amir@gmail.com',
                'password' => '$2a$12$LJnFNEBXPnO1KB2WSGapBO7YzbI8oRyQiHR5W9GT3.LY0sAvUU4VO',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'username' => 'uddin',
                'email' => 'uddin@gmail.com',
                'password' => '$2a$12$LJnFNEBXPnO1KB2WSGapBO7YzbI8oRyQiHR5W9GT3.LY0sAvUU4VO',
                'created_at' => null,
                'updated_at' => null,
            ],

        ];

        DB::table('users')->insert($user);
    }
}
