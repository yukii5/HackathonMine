<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 全件削除
        DB::table('project_user')->insert([
            [
                'project_id' => 1,
                'user_id' => 1
            ],
            [
                'project_id' => 1,
                'user_id' => 2
            ],
            [
                'project_id' => 1,
                'user_id' => 4
            ],
            [
                'project_id' => 1,
                'user_id' => 6
            ],
            [
                'project_id' => 2,
                'user_id' => 1
            ],
            [
                'project_id' => 2,
                'user_id' => 2
            ],
            [
                'project_id' => 2,
                'user_id' => 3
            ],
            [
                'project_id' => 2,
                'user_id' => 5
            ],
            [
                'project_id' => 2,
                'user_id' => 7
            ],
        ]);
    }
}
