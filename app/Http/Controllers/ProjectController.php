<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Project\StoreRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::select('projects.id', 'project_name', 'users.name', 'start_date', 'end_date', 'status_name')
        ->join('users', 'projects.responsible_person_id', '=', 'users.id')
        ->join('statuses', 'projects.status_code', '=', 'statuses.status_code')
        ->get();

        return view('index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('project.create')->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Project\StoreRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $project = new Project();
        $project->project_name = $data['project_name'];
        $project->responsible_person_id = $data['responsible_person_id'];
        $project->start_date = $data['start_date'];
        $project->end_date = $data['end_date'];
        
        $project->created_at = date('Y-m-d H:i:s');
        $project->updated_at = date('Y-m-d H:i:s');
        
        // todo ログイン中のユーザIDに変更する
        $project->created_user_id = 1;
        $project->updated_user_id = 1;

        $project->save();

        // メンバーの関連付け
        if (isset($data['user_id'])) {
            $project->users()->attach($data['user_id']);
        }

        // 保存が完了したらリダイレクトなどの適切なレスポンスを返す
        // 例: リダイレクト先のルート名は適宜変更してください
        return redirect()->route('projects.index')->with('success', 'プロジェクトが保存されました');
    }

    /**
     * プロジェクト詳細画面
     * チケットの一覧を表示する
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function detail(Project $project, $id)
    {
        $project = Project::where('id', $id)->first();

        $tickets = Ticket::select(
            'tickets.id', 
            'ticket_name',
            'tickets.responsible_person_id',
            'users.name',
            'start_date', 
            'end_date',
            'statuses.status_name',
        )
        ->where('project_id', $id)
        ->join('users', 'tickets.responsible_person_id', '=', 'users.id')
        ->join('statuses', 'tickets.status_code', '=', 'statuses.status_code')
        ->get();

        return view('project.detail')
            ->with('project', $project)
            ->with('tickets', $tickets);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
