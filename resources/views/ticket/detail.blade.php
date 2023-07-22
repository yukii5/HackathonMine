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
            <h1 class="mb-3">{{ $ticket->ticket_name }}</h1>
            <p class="mb-3"><b>担当: {{ $ticket->responsible_person }}</b></p>
            <div class="mb-5 created-updated">
                <ul>
                    <li>開始日: {{ $start_date_f }}</li>
                    <li class="pt-1">期日　: {{ $end_date_f }}</li>
                </ul>
            </div>
            <form action="{{ route('ticket.status', ['pid' => $project->id, 'tid' => $ticket->id]) }}" class="t-status mb-4" method="post">
                @csrf
                @method('put')
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
            <div class="t-content text-bd mb-3">
                {{ $ticket->content }}
            </div>
            @if ($ticket->hasUpdatePolicy())
            <div class="text-end">
                <a href="{{ route('ticket.edit', ['pid' => $project->id, 'tid' => $ticket->id]) }}">編集</a>
            </div>
            @endif
            <div class="ps-3 text-black-50">
                <p>作成日: {{ $created_at }}　{{ $create_user }}</p>
                <p >更新日: {{ $updated_at }}　{{ $update_user }}</p>
            </div>
        </div>
        <div class="mt-5 comments">
            <p class="mb-3"><b>コメント</b></p>
            @foreach ($comments as $comment)
            <div class="comment-wrapper mt-4 @if($loop->last) border-none @endif">
                <p>
                    {{ $comment->name }}
                    <span class="text-black-50 ps-3">{{ $comment->CreatedAt() }}</span>
                    @if ($comment->user_id == Auth::user()->id)
                    <a class="" href="">削除</a>
                    @endif
                </p>

                <textarea readonly class="comment mb-2 form-control auto-resize-textarea">{{$comment->comment}}</textarea>
                @if ($comment->user_id == Auth::user()->id)
                <div class="text-end mb-3">
                    <button style="display:none;" class="comment-save btn btn-primary px-3">保存</button>
                    <button class="comment-edit btn btn-secondary px-3">編集</button>
                </div>
                @endif
            </div>
            @endforeach
            
            <form class="comment-add-wrapper" action="" method="post">
                <p>コメントを追加</p>
                @csrf
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="_error-msg">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <textarea class="comment mb-2 form-control auto-resize-textarea" name="comment" id="" cols="20" rows="3">{{ old('comment') }}</textarea>
                <div class="mb-3 text-end">
                    <button class="btn btn-primary px-3" type="submit">追加</button>
                </div>
            </form>
        </div>
        <div class="mb-5">
                <p>要確認 : </p>
                <ul>
                    @foreach($t_users as $id => $name)
                    <li>{{ $name }}</li>
                    @endforeach
                </ul>
        </div>
        @if ($ticket->hasDeletePolicy())
        <div class="t-del-btn d-flex justify-content-end mb-5">
            <form class="ps-2" action="{{ route('ticket.delete', ['pid' => $project->id, 'tid' => $ticket->id]) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger px-3">チケットを削除する</button>
            </form>
        </div>
        @endif
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
                    commentSaveBtn[index].style.display = 'inline-block';
                });
            });

            // コメント　保存ボタン
            commentSaveBtn.forEach((button, index) => {
                button.addEventListener('click', () => {
                    comment.forEach(element => {
                        element.readOnly = true;
                    });
                    commentSaveBtn[index].style.display = 'none';
                    commentEditBtn[index].style.display = 'inline-block';
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

        window.onload = function() {
            // エラーがあればスクロール
            scrollToError();
        };
        
        function scrollToError() {
            // エラーメッセージが含まれる要素を取得
            var errorElements = document.getElementsByClassName('_error-msg');
            
            if (errorElements.length > 0) {
                // 最初のエラーメッセージが含まれる要素を取得
                var firstErrorElement = errorElements[0];
                
                // 親要素を取得
                var parentElement = firstErrorElement.parentElement;

                // 親要素があればスクロール
                if (parentElement) {
                    // 親要素までの位置を取得
                    var parentPosition = getElementPosition(parentElement);

                    // スクロール位置を調整（例えば、エラーメッセージの上部が見えるようにスクロール）
                    var scrollOffset = parentPosition - 50;

                    // スクロール実行
                    window.scrollTo({
                        top: scrollOffset,
                        behavior: 'smooth' // スムーズスクロールするためにsmoothを指定
                    });
                }
            }
        }

        // 要素の絶対位置を取得する関数
        function getElementPosition(element) {
            var rect = element.getBoundingClientRect();
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
            return rect.top + scrollTop;
        }

        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        // 投稿されたコメントの文字数に合わせてテキストエリアの高さを調整する
        window.addEventListener('load', function() {
            const autoResizeTextareas = document.querySelectorAll('.auto-resize-textarea');
            autoResizeTextareas.forEach(textarea => autoResizeTextarea(textarea));
        });

        // 新たに追加するコメントの文字数に合わせてテキストエリアの高さを調整する
        const autoResizeTextareas = document.querySelectorAll('.auto-resize-textarea');
        
        autoResizeTextareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
            autoResizeTextarea(textarea);
            });
        });
    </script>
</body>

</html>