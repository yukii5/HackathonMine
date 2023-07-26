<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('created_at')->get();
        return view('user.index', compact('users'));
    }

    public function edit(Request $request, User $user)
    {
        return view('auth.edit', compact('user'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->validated();
        
        $user->name = $data['name'];
        $user->email = $data['email'];
        // $user->password = Hash::make($data['password']);
        $user->admin = $data['role'];

        $user->save();

        return redirect()->route('user.index');
    }
}
