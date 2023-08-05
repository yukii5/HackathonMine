<x-layout>

<div class="container-fluid">
    <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">TOP</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('project.detail', ['id' => $project->id]) }}">{{ $project->project_name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">（編集）</li>
        </ol>
    </nav>
    <form enctype="multipart/form-data" class="mt-5 entry-form" action="{{ route('project.edit.put', ['id' => $project->id]) }}" method="post">
        @method('PUT')
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="mb-4">
            <label for="project_name" class="form-label">プロジェクト名</label>
            <input type="text" name="project_name" class="form-control" value="@if (old('project_name')){{ old('project_name') }}@else{{ $project->project_name }}@endif">
        </div>
        <div class="mb-4 person-wrapper">
            <label for="responsible_person" class="form-label">責任者</label>
            <select name="responsible_person_id" class="form-select" aria-label="">
                <option selected value="">-</option>
                @foreach($users as $user)
                <option @if (empty(old('responsible_person_id')) && $project->responsible_person_id === $user->id)
                    selected
                    @elseif (old('responsible_person_id') == $user->id)
                    selected
                    @endif value="{{ $user->id }}" >
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="start_date" class="form-label">プロジェクトメンバー</label>
            <div class="mb-3">
                <input type="checkbox" class="form-check-input" id="select-all">
                <label for="select-all" class="form-check-label">全て</label>
            </div>
            @foreach($users as $user)
            <div class="mb-1">
                @if (!empty(old('user_id')) && in_array($user->id, old('user_id')))
                <?php $checked = 'checked'; ?>
                @elseif ( empty(old('user_id')) && !empty($p_users) && $p_users->contains($user->id))
                <?php $checked = 'checked'; ?>
                @else
                <?php $checked = ''; ?>
                @endif
                <input <?= $checked ?> type="checkbox" class="form-check-input" name="user_id[]" value="{{ $user->id }}" id="user_{{ $user->id }}">
                <label for="user_{{ $user->id }}" class="form-check-label">{{ $user->name }}</label>
            </div>
            @endforeach

        </div>

        <div class="d-flex justify-content-center complete-btn-grp pt-5 mb-5">
            <div><a class="text-light btn btn-secondary me-3" href="{{ route('project.detail', ['id' => $project->id]) }}"><b>戻る</b></a></div>
            <button type="submit" class="btn btn-primary me-3"><b>保存</b></button>
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
    selectAllCheckbox.addEventListener("change", function() {
        var checkboxes = document.querySelectorAll('input[name="user_name[]"]');

        if (selectAllCheckbox.checked) {
            // 「全選択」がチェックされた場合、すべてのチェックボックスを選択状態にする
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
        } else {
            // 「全選択」がチェック解除された場合、すべてのチェックボックスの選択を解除する
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }
    });
</script>

</x-layout>