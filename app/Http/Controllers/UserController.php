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

    public function edit(Request $request, $id)
    {
        session(['previous_url' => url()->previous()]);
        
        // 本人と管理者のみ編集可
        if (
            explode('/', $request->path())[1] !== (string)Auth::user()->id 
            && !Auth::user()->admin
        ) {
            abort(403);
        }
        
        $user = User::find($id);

        return view('auth.edit', compact('user'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->validated();
        
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (isset($data['n_password'])) {
            $user->password = Hash::make($data['n_password']);
        }
        
        $user->admin = $data['role'];

        $user->save();

        if ($user->admin) {
            return redirect()->route('user.index');
        }

        $back = session('previous_url');
        
        session()->forget('previous_url');
        
        return redirect($back);
    }

    public function delete(User $user)
    {
        // 管理者のみ
        if (!Auth::user()->admin) {
            abort(403);
        }

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
