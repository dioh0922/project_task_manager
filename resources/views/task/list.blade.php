<div>
    <header>
        @include('header')
        @include('auth.logout')
    </header>
    <html>
    <body>
        <div>
            <button onclick="location.href='task/create'">
                新規登録
            </button>
        </div>
        <table @style([
            'margin: auto',
        ])>
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
                            <button onclick="location.href='task/{{$task['id']}}'">
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
