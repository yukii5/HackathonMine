<x-layout>
<div class="container-fluid">
    <form enctype="multipart/form-data" class="mt-5 entry-form user-create" action="{{route('login')}}" method="post">
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
            <label for="mail" class="form-label">メールアドレス</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </div>
        <div class="mb-4 person-wrapper">
            <label for="password" class="form-label">パスワード</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        </div>
        <div class="d-flex justify-content-center complete-btn-grp pt-2 mb-5">
            <button type="submit" class="btn btn-primary"> {{ __('ログイン') }}</button>
        </div>
    </form>
</div>
</x-layout>