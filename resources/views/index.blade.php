<x-layout>
<div class="container-fluid">

<div class="table-wrap table-responsive pt-3">
    <p class="mt-3 mb-3">プロジェクトを選択してください。</p>
    <table class="table table-condensed">
        <thead>
            <tr class="bg-light">
                <td scope="col">プロジェクト名</td>
                <td scope="col">責任者</td>
                <td scope="col">ステータス</td>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr class="pb-3">
                <td class="ps-3">
                    <a href="{{ route('project.detail', ['id' => $project->id]) }}">{{ $project->project_name }}</a>
                </td>
                <td class="ps-2 @if($project->user_del)text-decoration-line-through @endif">{{ $project->name }}</td>
                <td class="ps-2">@if ($project->status_code === 'active')進行中@else終了@endif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<a class="btn btn-primary px-3" href="{{ route('project.create') }}">新規プロジェクト</a>
</div>
</x-layout>