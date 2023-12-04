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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $task)
                <tr>
                    <td>{{$task["summary"]}}</td>
                    <td>{{$task["created_at"]}}</td>
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
