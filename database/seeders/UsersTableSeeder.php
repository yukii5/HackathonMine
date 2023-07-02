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
                'email' => 'sasamoto@gmail.com',
                'admin' => true,
            ],
            [
                'name' => '山田太郎',
                'email' => 'yamada@gmail.com',
                'admin' => false,
            ],
            [
                'name' => '田中一郎',
                'email' => 'tanaka@gmail.com',
                'admin' => false,
            ],
            [
                'name' => '佐藤花子',
                'email' => 'satoh@gmail.com',
                'admin' => false,
            ],
            [
                'name' => '高橋次郎',
                'email' => 'takahashi@gmail.com',
                'admin' => false,
            ],
            [
                'name' => '伊藤美智子',
                'email' => 'itoh@gmail.com',
                'admin' => false,
            ],
            [
                'name' => '渡辺雅子',
                'email' => 'watanabe@gmail.com',
                'admin' => false,
            ],
            [
                'name' => '中村康夫',
                'email' => 'nakamura@gmail.com',
                'admin' => false,
            ],
            [
                'name' => '小林裕子',
                'email' => 'kobayashi@gmail.com',
                'admin' => false,
            ],
            [
                'name' => '加藤光子',
                'email' => 'kato@gmail.com',
                'admin' => false,
            ],
            [
                'name' => '吉田悠里',
                'email' => 'yoshida@gmail.com',
                'admin' => false,
            ],
        ];

        // DB::table('users')->truncate();
        
        foreach ($users as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'admin' => $user['admin'],
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
