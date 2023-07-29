<x-layout>

<div class="container-fluid">
    <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">TOP</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー一覧</li>
        </ol>
    </nav>
    <div class="table-wrap table-responsive pt-3">

        <h1 class="mb-5">ユーザー一覧</h1>

        <div class="mt-3 mb-5 text-end">
            <a class="btn btn-primary px-3" href="/register">新規登録</a>
        </div>
        <table class="table table-condensed">
            <thead>
                <tr class="bg-light">
                    <td scope="col">ユーザ名</td>
                    <td scope="col">メールアドレス</td>
                    <td scope="col">権限</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="pb-3">
                    <td class="ps-3">
                        <a href="{{ route('user.edit', ['id' => $user->id]) }}">{{ $user->name }}</a>
                    </td>
                    <td class="ps-2">{{ $user->email }}</td>
                    @if ($user->admin)
                    <td class="ps-2">管理者</td>
                    @else
                    <td class="ps-2">通常</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3 mb-5 text-end">
        <a class="btn btn-secondary px-3" href="/">戻る</a>
    </div>
</div>

</x-layout>