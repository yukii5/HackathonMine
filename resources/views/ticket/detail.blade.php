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
            <div class="text-bd mb-3">
                {{ $ticket->content }}
            </div>
            <div class="pe-2 text-end">
                <a href="">編集</a>
            </div>
        </div>
        <div class="mt-5">
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

            <div class="mb-4">
                <textarea class="mb-3 form-control" name="" id="" cols="20" rows="3"></textarea>
                <div class="mb-3">
                    <a class="btn btn-primary px-3" href="ticket_create.html">追加</a>
                </div>
            </div>
        </div>
        <div class="mt-5 mb-3">
            <a class="btn btn-secondary px-3" href="prj.html">戻る</a>
        </div>
        <div class="d-flex justify-content-end mb-5">
            <button class="btn btn-primary px-3">チケットを完了にする</button>
            <button class="btn btn-primary px-3">実施中に戻す</button>
            <form class="ps-2" action="{{ route('ticket.delete', ['pid' => $project->id, 'tid' => $ticket->id]) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger px-3">チケットを削除する</button>
            </form>
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