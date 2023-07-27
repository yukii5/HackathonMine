<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <title>Hackathon</title>
</head>

<body>
    <header class="navbar text-light bg-dark">
        <div class="container-fluid">
            <b class="fs-4">Hackathon Mine</b>
        </div>
    </header>
    <div class="container-fluid">
        <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">TOP</a></li>
                <li class="breadcrumb-item"><a href="/users">ユーザー一覧</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
            </ol>
        </nav>
        <div class="t-del-btn text-end mb-5">
            <a href="" onclick="event.preventDefault(); document.getElementById('user-del').submit();">このユーザーを削除</a>
        </div>
        <form class="mt-5 entry-form" action="{{ route('user.update', $user) }}" method="post">
            @csrf
            @method('put')
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="mb-4">
                <label for="name" class="form-label">ユーザー名</label>
                <input id="name" type="text" name="name" class="form-control" value="@if (!old('name')){{ $user->name }}@else{{ old('name') }}@endif">
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">メールアドレス</label>
                <input id="email" type="email" name="email" value="@if (!old('email')){{ $user->email }}@else{{ old('email') }}@endif" class="form-control">
            </div>
            <!-- <div class="mb-4">
                <label for="password" class="form-label">新しいパスワード</label>
                <input id="password" type="password" name="password" class="form-control">
            </div>
            <div class="mb-4">
                <label for="password-confirm" class="form-label">確認用パスワード</label>
                <input id="password-confirm" type="password" name="password_confirmation" class="form-control">
            </div> -->
            <div class="mb-4">
                <label for="admin" class="form-label">権限</label>
                @if (is_null(old('role'))) 
                <div class="form-check">
                    <input id="nomal_user" class="form-check-input" type="radio" name="role" value="0" @if (!($user->admin)) checked @endif>
                    <label class="form-check-label" for="nomal_user">通常</label>
                </div>
                <div class="form-check">
                    <input id="admin_user" class="form-check-input" type="radio" name="role" value="1" @if ($user->admin) checked @endif>
                    <label class="form-check-label" for="admin_user">管理者</label>
                </div>
                @else
                <div class="form-check">
                    <input id="nomal_user" class="form-check-input" type="radio" name="role" value="0" @if (old('role') == 0) checked @endif>
                    <label class="form-check-label" for="nomal_user">通常</label>
                </div>
                <div class="form-check">
                    <input id="admin_user" class="form-check-input" type="radio" name="role" value="1" @if (old('role') == 1) checked @endif>
                    <label class="form-check-label" for="admin_user">管理者</label>
                </div>
                @endif
                <div class="d-flex justify-content-center complete-btn-grp pt-5 mb-5">
                    <div><a class="text-light btn btn-secondary me-3" href="/users"><b>戻る</b></a></div>
                    <button type="submit" class="btn btn-primary me-3"><b>保存</b></button>
                </div>
                
            </div>
        </form>
        <form id="user-del" class="ps-2" action="{{ route('user.delete', $user) }}" method="post">
            @csrf
            @method('put')
        </form>
    </div>
</body>

</html>