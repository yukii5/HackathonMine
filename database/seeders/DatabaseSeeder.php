<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * cmd) php artisan db:seed
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            StatusesTableSeeder::class,
            UsersTableSeeder::class,
            ProjectsTableSeeder::class,
            TicketsTableSeeder::class,
            ProjectUserTableSeeder::class,
        ]);
    }
}
