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
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid _align-items-baseline">
            <b><a class="text-light fs-4 navbar-brand" href="#">Hackathon Mine</a></b>
            
            <div class="pt-1 text-end text-light">
                <p class="dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }} @if (Auth::user()->admin)（管理者）@endif</p>
                <ul class="dropdown-menu user-menu-end" aria-labelledby="navbarDropdown">
                    @if (Auth::user()->admin)
                    <li>
                        <a class="dropdown-item" href="/users">ユーザー一覧</a>
                    </li>
                    @else
                    <li>
                        <a class="dropdown-item" href="/">編集</a>
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
            </div>

        </div>
    </nav>

    <div class="container-fluid">

        <div class="table-wrap table-responsive pt-3">
            <p class="mt-3 mb-3">プロジェクトを選択してください。</p>
            <table class="table table-condensed">
                <thead>
                    <tr class="bg-light">
                        <td scope="col">プロジェクト名</td>
                        <td scope="col">責任者</td>
                        <td scope="col">ステータス</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr class="pb-3">
                        <td class="ps-3">
                            <a href="{{ route('project.detail', ['id' => $project->id]) }}">{{ $project->project_name }}</a>
                        </td>
                        <td class="ps-2">{{ $project->name }}</td>
                        <td class="ps-2">@if ($project->status_code === 'active')進行中@else終了@endif</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a class="btn btn-primary px-3" href="{{ route('project.create') }}">新規プロジェクト</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>