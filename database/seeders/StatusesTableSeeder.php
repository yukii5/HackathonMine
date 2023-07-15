<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 初期データの配列
        $statuses = [
            [
                'status_code' => 'not-started',
                'status_name' => '未対応',
                'sort' => 1,
            ],
            [
                'status_code' => 'active',
                'status_name' => '対応中',
                'sort' => 2,
            ],
            [
                'status_code' => 'done',
                'status_name' => '完了',
                'sort' => 3,
            ],
        ];

        
        // statusesテーブルに初期データを挿入
        DB::table('statuses')->insert($statuses);
    }
}
