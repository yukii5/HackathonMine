<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $projects = Project::join('users', 'projects.responsible_person_id', '=', 'users.id')
        //     ->join('statuses', 'projects.status_code', '=', 'statuses.status_code')
        //     ->get();

        return view('user.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // $projects = Project::join('users', 'projects.responsible_person_id', '=', 'users.id')
        //     ->join('statuses', 'projects.status_code', '=', 'statuses.status_code')
        //     ->get();

        return view('user.regist');
        // echo 'register!!';
    }
}
