<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');
        DB::table('users')->insertOrIgnore([
            [
                'name' => 'Тестов Админ Админович',
                'email' => 'admin@test.com',
                'password' => $password,
                'role'=>'admin'
            ],
            [
                'name' => 'Тестов Юзер Юзерович',
                'email' => 'user@test.com',
                'password' => $password,
                'role'=>'user'
            ],
        ],'email');
    }

}
