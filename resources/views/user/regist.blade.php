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
    <header class="navbar text-light bg-dark">
        <div class="container-fluid">
            <b class="fs-4">Hackathon Mine</b>
        </div>
    </header>
    <div class="container-fluid">
        <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">TOP</a></li>
                <li class="breadcrumb-item"><a href="/users.html">ユーザー一覧</a></li>
                <li class="breadcrumb-item active" aria-current="page">新規ユーザー作成</li>
            </ol>
        </nav>
        <form enctype="multipart/form-data" class="mt-5 entry-form" action="/" method="post">
            
            <div class="mb-4">
                <label for="name" class="form-label">ユーザー名</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">確認用パスワード</label>
                <input type="password_confirmation" name="password_confirmation" class="form-control">
            </div>
            <div class="mb-4">
                <label for="admin" class="form-label">権限</label>
                <div class="form-check">
                    <input id="nomal_user" class="form-check-input" type="radio" name="admin" value="0" checked>
                    <label class="form-check-label" for="nomal_user">通常</label>
                </div>
                <div class="form-check">
                    <input id="admin_user" class="form-check-input" type="radio" name="admin" value="1">
                    <label class="form-check-label" for="admin_user">管理者</label>
                </div>

                <div class="d-flex justify-content-center complete-btn-grp pt-5 mb-5">
                    <button type="submit" class="btn btn-primary me-3"><b>保存</b></button>
                    <div><a class="text-light btn btn-secondary me-3" href="/"><b>戻る</b></a></div>
                </div>
            </div>
        </form>
    </div>
        <script>
            // メンバー追加と削除
            function addMember() {
                
                // プルダウンで選択されたメンバーの名前を取得
                var memberSelect = document.getElementById("member-select");
                var selectedOption = memberSelect.options[memberSelect.selectedIndex];

                  // value属性のない選択肢は追加できないようにする
                if (selectedOption.value == 0) {
                    return;
                }

                var memberName = selectedOption.text;
                var memberId = selectedOption.value;

                  // プルダウンで選択されたメンバーの項目を非表示にする
                selectedOption.style.display = "none";

                // メンバー一覧に追加
                var memberList = document.getElementsByClassName("member-list")[0];
                var memberNameDiv = document.createElement("div");
                memberNameDiv.className = "pb-1 member-name";
                memberNameDiv.innerHTML = '<span>' + memberName + '</span><input type="hidden" name="user_name[]" class="form-control" value="' + memberId + '"><a class="ps-3" href="javascript:void(0)">削除</a>';
                memberList.appendChild(memberNameDiv);
                
                // 削除ボタンを押したときの処理
                var deleteBtn = memberNameDiv.getElementsByTagName("a")[0];
                
                deleteBtn.onclick = function() {
                    memberList.removeChild(memberNameDiv);
                    // 削除されたメンバーの項目を再表示する
                    selectedOption.style.display = "";
                    // プルダウンをデフォルトにリセットする
                    memberSelect.selectedIndex = 0;
                };

                // プルダウンをデフォルトにリセットする
                memberSelect.selectedIndex = 0;
            }

            // 「全選択」チェックボックスの要素を取得
            var selectAllCheckbox = document.getElementById("select-all");

            // 「全選択」チェックボックスが変更された時の処理
            selectAllCheckbox.addEventListener("change", function () {
                var checkboxes = document.querySelectorAll('input[name="user_name[]"]');

                if (selectAllCheckbox.checked) {
                    // 「全選択」がチェックされた場合、すべてのチェックボックスを選択状態にする
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = true;
                    });
                } else {
                    // 「全選択」がチェック解除された場合、すべてのチェックボックスの選択を解除する
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = false;
                    });
                }
            });
        </script>
</body>

</html>