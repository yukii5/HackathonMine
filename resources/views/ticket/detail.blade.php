<x-layout>

<div class="container-fluid">
    <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">TOP</a></li>
            <li class="breadcrumb-item"><a href="{{ route('project.detail', ['id' => $project->id]) }}">{{ $project->project_name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $ticket->ticket_name }}</li>
        </ol>
    </nav>
    <div class="table-wrap table-responsive pt-3">

        <h1 class="mb-3">{{ $ticket->ticket_name }}</h1>
        @if (!$ticket->responsible_del)
        <p class="mb-3"><b>担当: {{ $ticket->responsible_person }}</b></p>
        @else
        <p class="mb-3 text-decoration-line-through"><b>担当: {{ $ticket->responsible_person }}</b></p>
        @endif
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
        <div class="t-content ps-3 mb-3">
            <pre>{{ $ticket->content }}</pre>
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
        <form id="comment-{{$comment->id}}" action="{{ route('comment.update', $comment) }}" class="comment-wrapper mt-4 @if($loop->last) border-none @endif" method="post">
            @method('put')
            @csrf
            <p>
                @if (!$comment->user_del)
                <span>{{ $comment->name }}</span>
                @else
                <span class="text-decoration-line-through">{{ $comment->name }}</span>
                @endif
                <span class="text-black-50 ps-3">{{ $comment->CreatedAt() }}</span>
                @if ($comment->user_id == Auth::user()->id)
                <a class="del-btn-{{$comment->id}}" href="javascript:;" onclick="submitDelForm({{$comment->id}})">削除</a>
                @endif
            </p>

            <textarea name="comment" readonly class="comment mb-2 form-control auto-resize-textarea">{{$comment->comment}}</textarea>
            @if ($comment->user_id == Auth::user()->id)
            <div class="text-end mb-3">
                <button type="submit" style="display:none;" class="comment-save btn btn-primary px-3">保存</button>
                <button class="comment-edit btn btn-secondary px-3">編集</button>
            </div>
            @endif
        </form>
        <form class="del-form-{{$comment->id}}" action="{{ route('comment.delete', $comment) }}" method="post">
            @method('delete')
            @csrf
        </form>
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

        const commentEditBtns = document.querySelectorAll('.comment-edit');
        const commentSaveBtns= document.querySelectorAll('.comment-save');
        const textAreas = document.getElementsByClassName('comment');

        // コメント 編集ボタン
        commentEditBtns.forEach((editBtn) => {
            editBtn.addEventListener('click', (event) => {
                
                const parentWrapper = editBtn.closest('.comment-wrapper');
                const commentTextarea = parentWrapper.querySelector('.comment');

                // 編集開始時に元の値を保持する
                commentTextarea.dataset.originalValue = commentTextarea.value;

                commentTextarea.readOnly = false;

                editBtn.style.display = 'none';

                const commentSaveBtn = parentWrapper.querySelector('.comment-save');
                commentSaveBtn.style.display = 'inline-block';

                event.preventDefault();
            });
        });

        // コメント　保存ボタン
        commentSaveBtns.forEach((saveBtn) => {
            saveBtn.addEventListener('click', () => {
                
                const parentWrapper = saveBtn.closest('.comment-wrapper');
                const commentTextarea = parentWrapper.querySelector('.comment');
                commentTextarea.readOnly = true;

                saveBtn.style.display = 'none';

                const commentEditBtn = parentWrapper.querySelector('.comment-edit');
                commentEditBtn.style.display = 'inline-block';

            });
        });

        // 編集状態を解除
        document.addEventListener('click', (event) => {

            // 編集ボタン自身は解除の対象外 （編集可能状態にならないため）
            if (event.target.classList.contains('comment-edit')) {
                return true;
            }
            // textAreasを配列に変換
            const textAreaArray = Array.from(textAreas);

            // クリックされた要素がテキストエリアか、テキストエリアの親要素かを確認
            const isTextAreaOrParent = textAreaArray.some((textarea) => {
                return textarea === event.target || textarea.contains(event.target);
            });

            // クリックされた要素がテキストエリア以外の場合、テキストエリアを読み取り専用に戻し、編集ボタンを表示する
            if (!isTextAreaOrParent) {
                textAreaArray.forEach((textarea) => {
                    if (!textarea.readOnly) {
                        const parentForm = textarea.closest('.comment-wrapper');
                        const commentEditBtn = parentForm.querySelector('.comment-edit');
                        const commentSaveBtn = parentForm.querySelector('.comment-save');
                        
                        // 編集をキャンセルして元の値に戻す
                        textarea.value = textarea.dataset.originalValue;
                        
                        textarea.readOnly = true;
                        commentEditBtn.style.display = 'inline-block';
                        commentSaveBtn.style.display = 'none';
                    }
                });
            }
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

    // コメント削除
    function submitDelForm(commentId) {
        const form = document.querySelector('.del-form-' + commentId);

        if (form) {
            form.submit();
        }
    }

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
</x-layout>