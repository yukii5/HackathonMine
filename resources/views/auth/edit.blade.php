<x-layout>

<div class="container-fluid">
    
    <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    @if (Auth::user()->admin)
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">TOP</a></li>
            <li class="breadcrumb-item"><a href="/users">ユーザー一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
        </ol>
    @endif
    </nav>
    @if (Auth::user()->admin)
    <div class="t-del-btn text-end mb-5">
        <a href="" onclick="event.preventDefault(); document.getElementById('user-del').submit();">このユーザーを削除</a>
    </div>
    @endif
    <form class="mt-5 entry-form user-create" action="{{ route('user.update', $user) }}" method="post">
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
        <div class="mb-4 person-wrapper">
            <label for="name" class="form-label">ユーザー名</label>
            <input id="name" type="text" name="name" class="form-control" value="@if (!old('name')){{ $user->name }}@else{{ old('name') }}@endif">
        </div>
        <div class="mb-4 person-wrapper">
            <label for="email" class="form-label">メールアドレス</label>
            <input id="email" type="email" name="email" value="@if (!old('email')){{ $user->email }}@else{{ old('email') }}@endif" class="form-control">
        </div>
        @if ($user->id == Auth::user()->id)
        <div class="pt-4 text-end person-wrapper">
            @if (old('pass_edit'))
            <p id="password-ch-btn" class="btn btn-secondary">パスワードを変更しない</p>
            @else
            <p id="password-ch-btn" class="btn btn-primary">パスワードを変更する</p>
            @endif
        </div>
        <div class="mb-4 person-wrapper">
            <label for="o-password" class="text-black-50 form-label passwd-grp">現在のパスワード</label>
            <input @if(!old('pass_edit')) disabled @endif id="o-password" type="password" name="o_password" class="form-control">
        </div>
        <div class="mb-4 person-wrapper">
            <label for="n-password" class="text-black-50 form-label passwd-grp">新しいパスワード</label>
            <input @if(!old('pass_edit')) disabled @endif id="n-password" type="password" name="n_password" class="form-control">
        </div>
        <div class="mb-4 person-wrapper">
            <label for="n-password-confirm" class="text-black-50 form-label passwd-grp">新しいパスワード（確認用）</label>
            <input @if(!old('pass_edit')) disabled @endif id="n-password-confirm" type="password" name="n_password_confirmation" class="form-control">
        </div>
        
        <input id="pass_edit" type="hidden" name="pass_edit" value="{{old('pass_edit')}}">
        @endif
        <div class="mb-4 person-wrapper">
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
                @if ($user->admin)
                <div><a class="text-light btn btn-secondary me-3" href="/users"><b>戻る</b></a></div>
                @endif
                <button type="submit" class="btn btn-primary me-3"><b>保存</b></button>
            </div>
            
        </div>
    </form>
    <form id="user-del" class="ps-2" action="{{ route('user.delete', $user) }}" method="post">
        @csrf
        @method('put')
    </form>
</div>
<script>
    let isEditing = false;
    const passwordChangeButton = document.getElementById("password-ch-btn");
    const passwordInput = document.getElementById("o-password");
    const newPasswordInput = document.getElementById("n-password");
    const newPasswordConfirmInput = document.getElementById("n-password-confirm");
    const labels = document.querySelectorAll(".form-label.passwd-grp");
    const passEdit = document.getElementById("pass_edit");

    passwordChangeButton.addEventListener("click", function () {
        if (!isEditing) {
            labels.forEach((label) => {
                label.classList.remove("text-black-50");
            });

            passwordInput.disabled = false;
            newPasswordInput.disabled = false;
            newPasswordConfirmInput.disabled = false;
            passwordChangeButton.textContent = "パスワードを変更しない";
            passwordChangeButton.classList.remove("btn-primary");
            passwordChangeButton.classList.add("btn-secondary");
            
            passEdit.value = 1;
        } else {
            labels.forEach((label) => {
                label.classList.add("text-black-50");
            });

            passwordInput.disabled = true;
            newPasswordInput.disabled = true;
            newPasswordConfirmInput.disabled = true;
            passwordChangeButton.textContent = "パスワードを変更する";
            passwordChangeButton.classList.remove("btn-secondary");
            passwordChangeButton.classList.add("btn-primary");
            
            passwordInput.value = "";
            newPasswordInput.value = "";
            newPasswordConfirmInput.value = "";
            passEdit.value = "";
        }
        isEditing = !isEditing;
    });
</script>
</x-layout>