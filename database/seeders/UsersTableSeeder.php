<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => '笹本健',
                'email' => 'sasamoto@gmail.com'
            ],
            [
                'name' => '山田太郎',
                'email' => 'yamada@gmail.com'
            ],
            [
                'name' => '田中一郎',
                'email' => 'tanaka@gmail.com'
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'user_name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'admin' => false,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
