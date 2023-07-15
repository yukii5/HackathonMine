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
                <li class="breadcrumb-item"><a href="{{ route('project.detail', ['id' => $project->id]) }}">{{ $project->project_name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $ticket->ticket_name }}</li>
            </ol>
        </nav>
        <div class="table-wrap table-responsive pt-3">
            <div class="text-end mb-3">
                <p>笹本　健</p>
                <p><a href="">ログアウト</a></p>
            </div>
            <p>{{ $project->project_name }}</p>
            <h1 class="mb-3">{{ $ticket->ticket_name }}</h1>
            <p class="mb-3"><b>担当: {{ $ticket->responsible_person }}</b></p>
            <div>
                <p>開始日: {{ $start_date_f }}　期日: {{ $end_date_f }}　作成者: {{ $create_user }}　更新者: {{ $update_user }}</p>
            </div>

            <form action="{{ route('ticket.status', ['pid' => $project->id, 'tid' => $ticket->id]) }}" class="t-status mb-4" method="post">
                @csrf
                @method('put')
                <label for="t-status" class="form-label pe-2">ステータス : </label>
                <div class="d-flex justify-content-end">
                    <select name="t-status" id="t-status" class="me-2 form-control">
                        @foreach($statuses as $code => $name)
                            <option @if ($ticket->status_code == $code) selected @endif value="{{$code}}">{{$name}}</option>
                        @endforeach
                    </select>
                    <div>
                    <button class="btn btn-primary px-3" type="submit">更新</button>
                    </div>
                </div>
            </form>
            <div class="mb-1 ps-2">
                <a href="{{ route('ticket.edit', ['pid' => $project->id, 'tid' => $ticket->id]) }}">編集</a>
            </div>
            <div class="t-content text-bd mb-3">
                {{ $ticket->content }}
            </div>
        </div>
        <div class="mt-3">
            <p class="mb-3"><b>コメント</b></p>
            <div class="comment-wrapper">
                <p>
                    山田太郎
                    <span class="ps-3">2023/06/03 8:00</span>
                    <a class="" href="">削除</a>
                </p>

                <textarea readonly class="comment mb-3 form-control" name="" id="" cols="20" rows="3">コメントコメントコメントコメントコメントコメントコメントコメント</textarea>
                <div class="mb-3">
                    <button style="display:none;" class="comment-save btn btn-primary px-3">保存</button>
                    <button class="comment-edit btn btn-primary px-3">編集</button>
                </div>
            </div>

            <div class="mb-5">
                <textarea class="mb-3 form-control" name="" id="" cols="20" rows="3"></textarea>
                <div class="mb-3">
                    <a class="btn btn-primary px-3" href="ticket_create.html">追加</a>
                </div>
            </div>
        </div>
        <div class="mb-5">
                <p>要確認 : </p>
                <ul>
                    @foreach($t_users as $id => $name)
                    <li>{{ $name }}</li>
                    @endforeach
                </ul>
        </div>

        <div class="d-flex justify-content-end mb-5">
            <form class="ps-2" action="{{ route('ticket.delete', ['pid' => $project->id, 'tid' => $ticket->id]) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger px-3">チケットを削除する</button>
            </form>
        </div>

        <div class="mt-5 mb-5">
            <a class="btn btn-secondary px-3" href="{{ route('project.detail', ['id' => $project->id]) }}">戻る</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const comment = document.querySelectorAll('.comment');
            const commentEditBtn = document.querySelectorAll('.comment-edit');
            const commentSaveBtn = document.querySelectorAll('.comment-save');

            // コメント 編集ボタン
            commentEditBtn.forEach((button, index) => {
                button.addEventListener('click', () => {
                    comment.forEach(element => {
                        element.readOnly = false;
                    });
                    commentEditBtn[index].style.display = 'none';
                    commentSaveBtn[index].style.display = 'block';
                });
            });

            // コメント　保存ボタン
            commentSaveBtn.forEach((button, index) => {
                button.addEventListener('click', () => {
                    comment.forEach(element => {
                        element.readOnly = true;
                    });
                    commentSaveBtn[index].style.display = 'none';
                    commentEditBtn[index].style.display = 'block';
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const editLinks = document.querySelectorAll('.edit');

            editLinks.forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault(); // デフォルトのリンク動作をキャンセル
                });
            });
        });
    </script>
</body>

</html>