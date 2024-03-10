<div>
    <header>
        @include('header')
    </header>
    <html>
    <body>

        <table class='table w-75 mx-auto'>
            <thead>
                <tr>
                    <th>タイトル</th>
                    <th>作成日時</th>
                    <th>関連下位</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $task)
                <tr>
                    <td>{{$task["summary"]}}</td>
                    <td>{{$task["created_at"]}}</td>
                    <td>
                        @if($task["base_task_id"] != null)
                            <button class="mx-2 btn btn-sm btn-outline-danger" onclick="location.href = '{{route('relation.show', ['relation' => $task['id']])}}'">有</button>
                        @endif
                    </td>
                    <td>
                        @if($task["is_delete"] === 1)
                            <div>完了済</div>
                        @endif
                        <div>
                            <button onclick="location.href='task/{{$task['id']}}'"
                            @class([
                                'btn',
                                'btn-secondary' => $task['is_delete'],
                                'btn-primary' => !$task['is_delete']
                            ])>
                                詳細
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
</div>
