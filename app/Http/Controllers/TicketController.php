<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Status;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\Ticket\StoreRequest;
use App\Http\Requests\Ticket\UpdateRequest;
use App\Http\Requests\Ticket\StatusRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    public function create($id)
    {
        $old_user_id = [];
        
        $session_data = session()->all();

        // 選択中の要確認メンバー(id)を取得
        if (isset($session_data["_old_input"])) {
            
            if (isset($session_data["_old_input"]["user_id"])) {
                $old_user_id = $session_data["_old_input"]["user_id"];
            }
        }

        $project = Project::where('id', $id)->first();
        
        $this->authorize('view', $project);
        
        $users = User::select('users.id AS user_id', 'users.name AS user_name')
        ->join('project_user', 'users.id', '=', 'project_user.user_id')
        ->join('projects', 'project_user.project_id', '=', 'projects.id')
        ->where('projects.id', $id)
        ->where('users.del_flg', 0)
            ->orderBy('users.id')
            ->pluck('user_name', 'user_id'); // key: = user_id, value: = user_name

        return view('ticket.create')
            ->with('id', $id)
            ->with('project', $project)
            ->with('users', $users)
            ->with('old_user_id', $old_user_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Ticket\StoreRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, $id)
    {
        $project = Project::where('id', $id)->first();
        
        $this->authorize('view', $project);

        $data = $request->validated();

        $ticket = new Ticket();
        $ticket->ticket_name = $data['ticket_name'];
        $ticket->responsible_person_id = $data['t_responsible_person_id'];
        $ticket->project_id = $id;
        $ticket->content = $data['content'];
        $ticket->start_date = $data['start_date'];
        $ticket->end_date = $data['end_date'];

        $ticket->created_at = date('Y-m-d H:i:s');
        $ticket->updated_at = date('Y-m-d H:i:s');

        $ticket->created_user_id = Auth::user()->id;
        $ticket->updated_user_id = Auth::user()->id;

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
        
        $this->authorize('view', $project);

        $ticket = Ticket::select(
            'tickets.id', 
            'ticket_name', 
            'content', 
            'start_date', 
            'end_date', 
            'users.name AS responsible_person', 
            'users.del_flg AS responsible_del', 
            'responsible_person_id', 
            'created_user_id', 
            'project_id', 
            'status_code',
            'tickets.created_at',
            'tickets.updated_at',
            )
            ->join('users', 'tickets.responsible_person_id', '=', 'users.id')
            ->where('tickets.id', $tid)->first();

        $t_users = DB::table('ticket_user')
            ->join('users', 'ticket_user.user_id', '=', 'users.id')
            ->join('tickets', 'ticket_user.ticket_id', '=', 'tickets.id')
            ->select('ticket_user.user_id AS id', 'users.name AS name')
            ->where('tickets.id', $tid)
            ->pluck('name', 'id');
        
        $create_user = User::select('users.name AS create_user')
            ->join('tickets', 'users.id', '=', 'tickets.created_user_id')
            ->where('tickets.id', $tid)
            ->value('create_user');
        
        $update_user = User::select('users.name AS update_user')
            ->join('tickets', 'users.id', '=', 'tickets.updated_user_id')
            ->where('tickets.id', $tid)
            ->value('update_user');

        $statuses = Status::select('status_code', 'status_name')
            ->pluck('status_name', 'status_code');

        $comments = Comment::select(
            'comments.id',
            'name',
            'comments.user_id AS user_id',
            'comments.created_at',
            'comment',
            'users.del_flg as user_del'
            )
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->where('ticket_id', $tid)
            ->orderBy('comments.created_at', 'ASC')->get();

        return view('ticket.detail')
            ->with('project', $project)
            ->with('ticket', $ticket)
            ->with('start_date_f', \Carbon\Carbon::parse($ticket->start_date)->format('Y/m/d'))
            ->with('end_date_f', \Carbon\Carbon::parse($ticket->end_date)->format('Y/m/d'))
            ->with('created_at', \Carbon\Carbon::parse($ticket->created_at)->format('Y/m/d'))
            ->with('updated_at', \Carbon\Carbon::parse($ticket->updated_at)->format('Y/m/d'))
            ->with('t_users', $t_users)
            ->with('create_user', $create_user)
            ->with('update_user', $update_user)
            ->with('statuses', $statuses)
            ->with('comments', $comments);
    }

    public function edit($pid, $tid)
    {
        $old_user_id = [];
        
        $session_data = session()->all();
        
        // 選択中の要確認メンバー(id)を取得
        if (isset($session_data["_old_input"])) {
            if (isset($session_data["_old_input"]["user_id"])) {
                $old_user_id = $session_data["_old_input"]["user_id"];
            }
        }

        $project = Project::where('id', $pid)->first();
        
        $users = User::select('users.id AS user_id', 'users.name AS user_name')
        ->join('project_user', 'users.id', '=', 'project_user.user_id')
        ->where('project_user.project_id', $pid)
        ->where('users.del_flg', 0)
        ->orderBy('users.id')
        ->pluck('user_name', 'user_id'); // key: = user_id, value: = user_name

        $ticket = Ticket::join('users', 'tickets.responsible_person_id', '=', 'users.id')
        ->select(
            'tickets.id', 
            'ticket_name', 
            'content', 
            'start_date', 
            'end_date', 
            'responsible_person_id', 
            'created_user_id',
            'users.name AS responsible_person'
            )
        ->where('tickets.id', $tid)
        ->first();

        $this->authorize('update', $ticket);

        $t_users = DB::table('ticket_user')
        ->join('users', 'ticket_user.user_id', '=', 'users.id')
        ->join('tickets', 'ticket_user.ticket_id', '=', 'tickets.id')
        ->select('ticket_user.user_id AS id', 'users.name AS name')
        ->where('tickets.id', $tid)
        ->pluck('name', 'id');

        // キーのみの配列に変換
        $t_user_keys = array_keys($t_users->toArray());
        
        return view('ticket.edit')
            ->with('id', $pid)
            ->with('project', $project)
            ->with('users', $users)
            ->with('ticket', $ticket)
            ->with('start_date_f', \Carbon\Carbon::parse($ticket->start_date)->format('Y-m-d'))
            ->with('end_date_f', \Carbon\Carbon::parse($ticket->end_date)->format('Y-m-d'))
            ->with('old_user_id', $old_user_id)
            ->with('t_users', $t_users)
            ->with('t_user_keys', $t_user_keys);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  \App\Http\Requests\Ticket\UpdateRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $pid, $tid)
    {
        $project = Project::where('id', $pid)->first();
        
        $this->authorize('view', $project);

        $data = $request->validated();

        $ticket = Ticket::where('id', $tid)->first();
        
        $this->authorize('update', $ticket);

        $ticket->ticket_name = $data['ticket_name'];
        $ticket->responsible_person_id = $data['t_responsible_person_id'];
        // $ticket->project_id = $id;
        $ticket->content = $data['content'];
        $ticket->start_date = $data['start_date'];
        $ticket->end_date = $data['end_date'];

        $ticket->updated_at = date('Y-m-d H:i:s');

        $ticket->updated_user_id = Auth::user()->id;

        $ticket->save();
        
        // （関連）要確認メンバーの初期化
        $ticket->users()->detach();
        
        if (isset($data['user_id'])) {
            $ticket->users()->attach($data['user_id']);
        }
        
        return redirect()->route('ticket.show', ['pid' => $pid, 'tid' => $tid] );
    }

    public function status(StatusRequest $request, $pid, $tid)
    {
        $project = Project::where('id', $pid)->first();
        
        $this->authorize('view', $project);

        $data = $request->validated();

        $ticket = Ticket::where('id', $tid)->first();

        $ticket->status_code = $data['t-status'];

        $ticket->save();

        if ($ticket->status_code === 'done') {
            return redirect()->route('project.detail', ['id' => $pid]);
        }

        return redirect()->route('ticket.show', ['pid' => $pid, 'tid' => $tid] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function delete($pid, $tid)
    {
        $ticket = Ticket::find($tid);
        
        $this->authorize('delete', $ticket);

        $ticket->users()->detach();

        $ticket->delete();

        return redirect()->route('project.detail', ['id' => $pid]);
    }
}
