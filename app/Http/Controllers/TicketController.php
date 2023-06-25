<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ticket;
use Illuminate\Http\Request;
use App\Http\Requests\Ticket\StoreRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project, $id)
    {
        $project = Project::where('id', $id)->first();
        return view('ticket.create')
            ->with('id', $id)
            ->with('project', $project);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ticket\StoreRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, $id)
    {
        $data = $request->validated();

        $ticket = new Ticket();
        $ticket->ticket_name = $data['ticket_name'];
        $ticket->responsible_person_id = $data['responsible_person_id'];
        $ticket->project_id = $id;
        $ticket->content = $data['content'];
        $ticket->start_date = $data['start_date'];
        $ticket->end_date = $data['end_date'];

        $ticket->created_at = date('Y-m-d H:i:s');
        $ticket->updated_at = date('Y-m-d H:i:s');

        // todo ログイン中のユーザIDに変更する
        $ticket->created_user_id = 1;
        $ticket->updated_user_id = 1;

        $ticket->save();

        if (isset($data['user_id'])) {
            $ticket->users()->attach($data['user_id']);
        }
        
        return redirect()->route('project.detail', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(ticket $ticket)
    {
        /**
         * 
         * プロジェクトのメンバー
SELECT project_name, users.name FROM projects 
JOIN project_user ON projects.id = project_user.project_id 
JOIN users ON users.id = project_user.user_id 
WHERE projects.id = :id
         */

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(ticket $ticket)
    {
        //
    }
}
