<div>
    <header>
        @include('header')
    </header>
    <html>
    <body>
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
                        <button onclick="location.href='task/{{$task['id']}}'">
                            詳細
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
</div>
