<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            [
                'project_name' => 'プロジェクトXXX',
                'responsible_person_id' => 1,
                'status_code' => 'active',
                'created_at' => now(),
                'created_user_id' => 1,
                'updated_at' => now(),
                'updated_user_id' => 1,
                'del_flg' => false,
            ],
            [
                'project_name' => 'プロジェクトYYY',
                'responsible_person_id' => 2,
                'status_code' => 'active',
                'created_at' => now(),
                'created_user_id' => 2,
                'updated_at' => now(),
                'updated_user_id' => 2,
                'del_flg' => false,
            ],
        ]);
    }
}
