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
                <li class="breadcrumb-item active" aria-current="page">新規登録</li>
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
                    <div><a class="text-light btn btn-secondary me-3" href="/"><b>戻る</b></a></div>
                    <button type="submit" class="btn btn-primary me-3"><b>登録</b></button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>