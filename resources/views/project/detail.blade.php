<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
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
                <li class="breadcrumb-item active" aria-current="page">{{ $project->project_name }}</li>
            </ol>
        </nav>
        <div class="table-wrap table-responsive pt-3">
            <div class="text-end mb-3">
                <p>笹本　健</p>
                <p><a href="">ログアウト</a></p>
            </div>
            <h1 class="mb-3">{{ $project->project_name }}</h1>
            <p class="mb-5"><b>責任者: {{ $project->leader }}</b></p>
            <p>チケット一覧</p>
            <table class="mb-5 table table-condensed">
                <thead>
                    <tr class="bg-light">
                        <td scope="col">タイトル</td>
                        <td scope="col">開始日</td>
                        <td scope="col">期日</td>
                        <td scope="col">担当</td>
                        <td scope="col">ステータス</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr class="pb-3">
                        <td class="ps-3">
                            <a href="{{ route('ticket.show', ['pid' => $project->id, 'tid' => $ticket->id] ) }}">{{ $ticket->ticket_name }}</a>
                        </td>
                        <td class="ps-2">{{ \Carbon\Carbon::parse($ticket->start_date)->format('Y/m/d') }}</td>
                        <td class="ps-2">{{ \Carbon\Carbon::parse($ticket->end_date)->format('Y/m/d') }}</td>
                        <td class="ps-2">{{ $ticket->name }}</td>
                        <td class="ps-2">{{ $ticket->status_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mb-5">
                <p>プロジェクトメンバー</p>
                <ul>
                    @foreach($users as $user)
                        @if($user->id != $project->leader_id)
                        <li>{{ $user->user_name }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div>
            <a class="btn btn-primary px-3" href="/{{ request()->path() }}/ticket/create">チケット作成</a>
            <a class="btn btn-secondary px-3" href="/">戻る</a>
        </div>
        <div class="text-end">
            <button class="btn btn-primary px-3">プロジェクト完了</button>
            <button class="btn btn-danger px-3">プロジェクト削除</button>
        </div>
    </div>
</body>

</html>