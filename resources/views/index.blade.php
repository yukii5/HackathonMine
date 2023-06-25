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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="ms-3 collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="text-light nav-link" href="/users">ユーザー一覧</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">

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

            <p class="mt-3 mb-3">プロジェクトを選択してください。</p>
            <table class="table table-condensed">
                <thead>
                    <tr class="bg-light">
                        <td scope="col">プロジェクト名</td>
                        <td scope="col">責任者</td>
                        <td scope="col">開始日</td>
                        <td scope="col">終了日</td>
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
                        <td class="ps-2">{{ \Carbon\Carbon::parse($project->start_date)->format('Y/m/d') }}</td>
                        <td class="ps-2">{{ \Carbon\Carbon::parse($project->end_date)->format('Y/m/d') }}</td>
                        <td class="ps-2">{{ $project->status_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a class="btn btn-primary px-3" href="{{ route('project.create') }}">新規プロジェクト</a>
    </div>
</body>

</html>