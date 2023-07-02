<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Ticket\StoreRequest;
use Illuminate\Support\Facades\DB;

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
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket, $pid, $tid)
    {
        $project = Project::where('id', $pid)->first();

        $ticket = DB::table('tickets')
            ->join('users', 'tickets.responsible_person_id', '=', 'users.id')
            ->select('ticket_name', 'content', 'start_date', 'end_date', 'users.name AS responsible_person')
            ->where('tickets.id', $tid)->first();
        
        $create_user = User::select('users.name AS create_user')
            ->join('tickets', 'users.id', '=', 'tickets.created_user_id')
            ->where('tickets.id', $tid)
            ->value('create_user');
        
        $update_user = User::select('users.name AS update_user')
            ->join('tickets', 'users.id', '=', 'tickets.updated_user_id')
            ->where('tickets.id', $tid)
            ->value('update_user');

        return view('ticket.detail')
            ->with('project', $project)
            ->with('ticket', $ticket)
            ->with('start_date_f', \Carbon\Carbon::parse($ticket->start_date)->format('Y/m/d'))
            ->with('end_date_f', \Carbon\Carbon::parse($ticket->end_date)->format('Y/m/d'))
            ->with('create_user', $create_user)
            ->with('update_user', $update_user);
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
