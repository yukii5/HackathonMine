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
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid _align-items-baseline">
            <b><a class="text-light fs-4 navbar-brand" href="/">Hackathon Mine</a></b>
            @if (Auth::check())
            <div class="pt-1 text-end text-light">
                <p class="dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }} @if (Auth::user()->admin)（管理者）@endif</p>
                <ul class="dropdown-menu user-menu-end" aria-labelledby="navbarDropdown">
                    @if (Auth::user()->admin)
                    <li>
                        <a class="dropdown-item" href="/users">ユーザー一覧</a>
                    </li>
                    @else
                    <li>
                        <a class="dropdown-item" href="{{ route('user.edit', ['id' => Auth::user()->id]) }}">編集</a>
                    </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{__('ログアウト') }}
                        </a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            @endif
        </div>
    </nav>
    {{ $slot }}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>