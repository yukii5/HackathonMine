<x-layout>

<div class="container-fluid pt-3">
    <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">TOP</a></li>
            <li class="breadcrumb-item"><a href="{{ route('project.detail', ['id' => $project->id]) }}">{{ $project->project_name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">新規チケット</li>
        </ol>
    </nav>

    <form enctype="multipart/form-data" class="mt-5 entry-form" action="{{ route('ticket.store', ['pid' => $project->id]) }}" method="POST">
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
            <label for="project_name" class="form-label">チケット名</label>
            <input type="text" name="ticket_name" class="form-control" value="{{ old('ticket_name') }}">
        </div>

        <div class="mb-4 person-wrapper">
            <label for="responsible" class="form-label pe-2">担当</label>
            <div>
                <select name="t_responsible_person_id" id="responsible" class="form-control">
                    <option value="">-</option>
                    @foreach($users as $k => $v)
                    <option value="{{ $k }}" {{ old('t_responsible_person_id') == $k ? 'selected' : '' }}>
                        {{ $v }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="date-wrapper">
            <div class="start-date-wrapper mb-4">
                <label for="start_date" class="form-label">開始日</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
            </div>
            <div class="end-date-wrapper mb-4">
                <label for="end_date" class="form-label">期日</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
            </div>
        </div>

        <div class="mb-4">
            <label for="content" class="form-label">内容</label>
            <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
        </div>
        <div class="mb-4 person-wrapper">
            <label for="user_name" class="form-label pe-2">要確認メンバー</label>
            <div>
                <select id="member-select" class="form-control">
                    <option value="">-</option>
                    @foreach($users as $k => $v)
                    <option @if(in_array($k, $old_user_id)) style="display: none;" @endif value="{{ $k }}">{{ $v }}
                    </option>
                    @endforeach
                </select>
                <div class="mt-3">
                    <input type="button" onclick="addMember()" value="追加" />
                </div>
            </div>
        </div>
        <div class="mb-4 member-list">
            @foreach($old_user_id as $id)
            <div class="pb-1 member-name"><span><?= $users[$id]; ?></span>
                <input type="hidden" name="user_id[]" class="form-control" value="{{ $id }}"><a onclick="deleteMember(this)" class="ps-3" href="javascript:void(0)">削除</a>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center complete-btn-grp pt-5 mb-5">
            <div><a class="text-light btn btn-secondary me-3" href="/project/{{ $project->id }}"><b>戻る</b></a></div>
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
        memberNameDiv.innerHTML = '<span>' + memberName + '</span><input type="hidden" name="user_id[]" class="form-control" value="' + memberId + '"><a onclick="deleteMember()" class="ps-3" href="javascript:void(0)">削除</a>';
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

    function deleteMember(element) {

        var parentDiv = element.parentNode;

        parentDiv.parentNode.removeChild(parentDiv);

        var deletedValue = parentDiv.querySelector('input[name="user_id[]"]').value;

        var options = document.getElementById('member-select').options;
        
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === deletedValue) {
                options[i].style.display = '';
                break;
            }
        }
    }


    // 「全選択」チェックボックスの要素を取得
    var selectAllCheckbox = document.getElementById("select-all");

    // 「全選択」チェックボックスが変更された時の処理
    selectAllCheckbox.addEventListener("change", function() {
        var checkboxes = document.querySelectorAll('input[name="user_id[]"]');

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