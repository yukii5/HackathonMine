<x-layout>
<div class="container-fluid">
    <form enctype="multipart/form-data" class="mt-5 entry-form" action="{{route('login')}}" method="post">
        @csrf
        <div class="mb-4">
            <label for="mail" class="form-label">メールアドレス</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">パスワード</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        </div>
        <div class="mb-4">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center complete-btn-grp pt-5 mb-5">
            <button type="submit" class="btn btn-primary"> {{ __('ログイン') }}</button>
        </div>
    </form>
</div>
</x-layout>