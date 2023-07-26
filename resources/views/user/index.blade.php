<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Hackathon</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg _navbar-light _bg-light bg-dark">
        <div class="container-fluid">
            <b><a class="text-light fs-4 navbar-brand" href="#">Hackathon Mine</a></b>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="ms-3 collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="text-light nav-link" href="#">ユーザー一覧</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">TOP</a></li>
                <li class="breadcrumb-item active" aria-current="page">ユーザー一覧</li>
            </ol>
        </nav>
        <div class="table-wrap table-responsive pt-3">
            <div class="text-end mb-3">
                <p>{{ Auth::user()->name }}</p>
                <div class="pt-1">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('ログアウト') }}
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

            <h1 class="mb-5">ユーザー一覧</h1>

            <div class="mt-3 mb-5 text-end">
                <a class="btn btn-primary px-3" href="/register">新規登録</a>
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr class="bg-light">
                        <td scope="col">ユーザ名</td>
                        <td scope="col">メールアドレス</td>
                        <td scope="col">権限</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="pb-3">
                        <td class="ps-3">
                            <a href="{{ route('user.edit', $user) }}">{{ $user->name }}</a>
                        </td>
                        <td class="ps-2">{{ $user->email }}</td>
                        @if ($user->admin)
                        <td class="ps-2">管理者</td>
                        @else
                        <td class="ps-2">通常</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 mb-5 text-end">
            <a class="btn btn-secondary px-3" href="/">戻る</a>
        </div>
    </div>
</body>

</html>