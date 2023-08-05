<x-layout>

<div class="container-fluid">
    <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">TOP</a></li>
            <li class="breadcrumb-item"><a href="/users">ユーザー一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">新規登録</li>
        </ol>
    </nav>
    <form class="mt-5 entry-form user-create" action="{{ route('register') }}" method="post">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mb-4 person-wrapper">
            <label for="name" class="form-label">ユーザー名</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="mb-4 person-wrapper">
            <label for="email" class="form-label">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control">
        </div>
        <div class="mb-4 person-wrapper">
            <label for="password" class="form-label">パスワード</label>
            <input id="password" type="password" name="password" class="form-control">
        </div>
        <div class="mb-4 person-wrapper">
            <label for="password-confirm" class="form-label">確認用パスワード</label>
            <input id="password-confirm" type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="mb-4 person-wrapper">
            <label for="admin" class="form-label">権限</label>
            <div class="form-check">
                <input id="nomal_user" class="form-check-input" type="radio" name="role" value="0" @if (old('role') == 0) checked @endif>
                <label class="form-check-label" for="nomal_user">通常</label>
            </div>
            <div class="form-check">
                <input id="admin_user" class="form-check-input" type="radio" name="role" value="1" @if (old('role') == 1) checked @endif>
                <label class="form-check-label" for="admin_user">管理者</label>
            </div>

            <div class="d-flex justify-content-center complete-btn-grp pt-5 mb-5">
                <div><a class="text-light btn btn-secondary me-3" href="/users"><b>戻る</b></a></div>
                <button type="submit" class="btn btn-primary me-3"><b>登録</b></button>
            </div>
        </div>
    </form>
</div>

</x-layout>