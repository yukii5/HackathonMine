<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketsTableSeeder extends Seeder
{
    public function run()
    {
        Ticket::create([
            'ticket_name' => 'Ticket 1',
            'responsible_person_id' => 1,
            'project_id' => 1,
            'content' => 'This is ticket 1',
            'start_date' => now(),
            'end_date' => null,
            'created_user_id' => 1,
            'updated_user_id' => 1,
            'del_flg' => false,
        ]);

        Ticket::create([
            'ticket_name' => 'Ticket 2',
            'responsible_person_id' => 2,
            'project_id' => 1,
            'content' => 'This is ticket 2',
            'start_date' => now(),
            'end_date' => null,
            'created_user_id' => 1,
            'updated_user_id' => 1,
            'del_flg' => false,
        ]); 

        Ticket::create([
            'ticket_name' => 'Ticket 3',
            'responsible_person_id' => 1,
            'project_id' => 2,
            'content' => 'This is ticket 3',
            'start_date' => now(),
            'end_date' => null,
            'created_user_id' => 1,
            'updated_user_id' => 1,
            'del_flg' => false,
        ]); 

        Ticket::create([
            'ticket_name' => 'Ticket 4',
            'responsible_person_id' => 1,
            'project_id' => 2,
            'content' => 'This is ticket 4',
            'start_date' => now(),
            'end_date' => null,
            'created_user_id' => 1,
            'updated_user_id' => 1,
            'del_flg' => false,
        ]); 
        Ticket::create([
            'ticket_name' => 'Ticket 5',
            'responsible_person_id' => 1,
            'project_id' => 3,
            'content' => 'This is ticket 4',
            'start_date' => now(),
            'end_date' => null,
            'created_user_id' => 1,
            'updated_user_id' => 1,
            'del_flg' => false,
        ]); 
    }
}
