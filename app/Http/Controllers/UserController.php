<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Auth::user());

        $users = User::orderBy('created_at')
            ->where('del_flg', 0)
            ->get();
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

    public function delete(User $user)
    {
        $user->del_flg = 1;

        $user->save();
        
        // 本人を削除 ログアウト
        if ($user->id === Auth::user()->id) {
            Auth::logout();
            return redirect()->route('projects.index');
        }

        return redirect()->route('user.index');
    }
}
