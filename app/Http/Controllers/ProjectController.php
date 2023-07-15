<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Project\StoreRequest;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::select('projects.id', 'project_name', 'users.name', 'status_code')
        ->join('users', 'projects.responsible_person_id', '=', 'users.id')
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
        
        $project->created_at = date('Y-m-d H:i:s');
        $project->updated_at = date('Y-m-d H:i:s');
        
        $project->created_user_id = Auth::user()->id;
        $project->updated_user_id = Auth::user()->id;

        $project->save();

        // メンバーの関連付け
        if (isset($data['user_id'])) {
            $project->users()->attach($data['user_id']);
        }
    
        // プロジェクトの責任者がプロジェクトメンバーに含まれていない場合は追加する
        if (!in_array($data['responsible_person_id'], $data['user_id'], true)) {
            $project->users()->attach($data['responsible_person_id']);
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
        $project = Project::select('projects.id', 'project_name', 'projects.created_at AS created_at', 'projects.updated_at AS updated_at', 'users.id as leader_id','users.name AS leader', 'projects.status_code AS status')
        ->join('users', 'projects.responsible_person_id', '=', 'users.id')
        ->where('projects.id', $id)->first();

        $users = User::select('users.id AS id', 'users.name AS user_name')
        ->join('project_user', 'users.id', '=', 'project_user.user_id')
        ->where('project_user.project_id', $id)->orderBy('users.id')->get();
        
        $create_user = User::select('users.name AS create_user')
        ->join('projects', 'projects.created_user_id', '=', 'users.id')
        ->where('projects.id', $id)->value('create_user');

        $update_user = User::select('users.name AS create_user')
        ->join('projects', 'projects.updated_user_id', '=', 'users.id')
        ->where('projects.id', $id)->value('create_user');

        $tickets = Ticket::select(
            'tickets.id', 
            'ticket_name',
            'tickets.responsible_person_id',
            'users.name',
            'statuses.status_name',
            'start_date',
            'end_date',
        )
        ->where('project_id', $id)
        ->join('users', 'tickets.responsible_person_id', '=', 'users.id')
        ->join('statuses', 'tickets.status_code', '=', 'statuses.status_code')
        ->orderBy('end_date', 'asc')
        ->get();

        return view('project.detail')
            ->with('project', $project)
            ->with('tickets', $tickets)
            ->with('users', $users)
            ->with('create_user', $create_user)
            ->with('update_user', $update_user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::select(
                'projects.id', 
                'project_name', 
                'projects.created_at AS created_at', 
                'projects.updated_at AS updated_at', 
                'users.id as leader_id', 
                'users.name AS leader'
            )
        ->join('users', 'projects.responsible_person_id', '=', 'users.id')
        ->where('projects.id', $id)->first();

        $users = User::all();

        $p_users = User::select('users.id AS id', 'users.name AS user_name')
        ->join('project_user', 'users.id', '=', 'project_user.user_id')
        ->where('project_user.project_id', $id)->orderBy('users.id')->get();
        
        return view('project.edit')
            ->with('project', $project)
            ->with('users', $users)
            ->with('p_users', $p_users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Project\StoreRequest
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request)
    {
        $data = $request->validated();
        
        $project = Project::where('id', $request->id())->first();

        $project->project_name = $data['project_name'];
        $project->responsible_person_id = $data['responsible_person_id'];

        $project->created_at = date('Y-m-d H:i:s');
        $project->updated_at = date('Y-m-d H:i:s');

        $project->updated_user_id = Auth::user()->id;

        $project->save();

        // プロジェクトメンバーを初期化
        $project->users()->detach();

        // メンバーの関連付け
        if (isset($data['user_id'])) {
            $project->users()->attach($data['user_id']);
        }

        // プロジェクトの責任者がプロジェクトメンバーに含まれていない場合は追加する
        if (!in_array($data['responsible_person_id'], $data['user_id'], true)) {
            $project->users()->attach($data['responsible_person_id']);
        }

        return redirect()->route('projects.index');
    }

    /**
     * プロジェクトのステータスを更新
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        $project = Project::where('id', $id)->first();

        if ($request->input('t-status') != '') {
            $project->status_code = $request->input('t-status') == 0 ? 'done' : 'active';
        }

        $project->save();

        if ($project->status_code == 'done') {
            return redirect()->route('projects.index');
        }
        return redirect()->route('project.detail', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Project\StoreRequest
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $project = Project::find($id);
        
        $project->users()->detach();
        
        $project->delete();
        
        return redirect()->route('projects.index');
    }
}
