<x-layout>

<div class="container-fluid">
    <nav class="my-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">TOP</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $project->project_name }}</li>
        </ol>
    </nav>
    <div class="table-wrap table-responsive pt-3">
        <h1 class="mb-3">{{ $project->project_name }}</h1>
        
        <div class="created-updated">
            <ul>
                <li>作成日 : {{ \Carbon\Carbon::parse($project->created_at)->format('Y/m/d') }}　{{ $create_user }}</li>
                <li class="pt-1">更新日 : {{ \Carbon\Carbon::parse($project->updated_at)->format('Y/m/d') }}　{{ $update_user }}</li>
            </ul>
        </div>

        <p class="mb-3">
            @if(!$project->leader_del)
            <b>責任者: {{ $project->leader }}</b>
            @else
            <b class="text-decoration-line-through">責任者: {{ $project->leader }}</b>
            @endif
        </p>

        <div class="mb-3">
            <p>メンバー</p>
            <ul>
                @foreach($users as $user)
                @if(!$user->del_flg)
                <li>
                    {{ $user->user_name }}
                    @if($user->id === $project->leader_id)
                    <span>（責任者）</span>
                    @endif
                </li>
                @endif
                @endforeach
            </ul>
        </div>
        @if ($project->hasPolicy())
        <div class="text-end mb-5">
            <a href="{{ route('project.edit', ['id' => $project->id]) }}">編集</a>
        </div>
        @endif
        <form action="{{ request()->fullUrl() }}" class="t-list-search mb-4">
            
            <div class="d-flex justify-content-end align-items-center">
                
                <label for="responsible">担当</label>
                <div class="ms-1">
                    <select name="responsible" id="responsible" class="me-2 form-control">
                        <option value="all">全て</option>
                        <option @if (request()->input('responsible') == Auth::user()->id) selected @endif value="{{ Auth::user()->id }}">自分</option>
                    </select>
                </div>
                
                <div class="ms-3">
                    <label for="">ステータス</label>
                </div>
                <div class="ms-1">
                    <select name="t-status" id="t-status" class="me-2 form-control">
                        <option value="all">全て</option>
                        @foreach($statuses as $code => $name)
                        <option @if (request()->input('t-status') == $code) selected @endif value="{{ $code }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ms-3">
                    <button class="btn btn-primary px-3" type="submit">再表示</button>
                </div>
            </div>
        </form>
        
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
                    @if ($ticket->del_flg) 
                    <td class="ps-2 text-decoration-line-through">{{ $ticket->name }}</td>
                    @else
                    <td class="ps-2">{{ $ticket->name }}</td>
                    @endif
                    <td class="ps-2">{{ $ticket->status_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <a class="btn btn-primary px-3" href="/{{ request()->path() }}/ticket/create">チケット作成</a>
    </div>
    @if ($project->hasPolicy())
    <div class="d-flex justify-content-end mb-5">
        <form class="ps-2" action="{{ route('project.status', ['id' => $project->id]) }}" method="post">
            @csrf
            @method('put')
            @if ($project->status == 'active')
            <button class="btn btn-secondary px-3">終了</button>
            <input type="hidden" name="p-status" value="0">
            @else
            <button class="btn btn-primary px-3">進行中に戻す</button>
            <input type="hidden" name="p-status" value="1">
            @endif
        </form>
        <form class="ps-2" action="{{ route('project.delete', ['id' => $project->id]) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger px-3">削除</button>
        </form>
    </div>
    @endif
    <div class="mt-5 mb-5">
        <a class="btn btn-secondary px-3" href="/">戻る</a>
    </div>
</div>

</x-layout>