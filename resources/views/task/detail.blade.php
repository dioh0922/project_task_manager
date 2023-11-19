<div>
    <header>
        @include('header')
    </header>
    <div @style([
        'margin: auto',
    ])>
        <p>{{$task['summary']}}</p>
        @if($task["is_delete"] === 0)
            {{Form::open(['method' => 'PUT', 'url' => 'task/'.$task['id']])}}
            {{Form::token()}}
            {{Form::label('detail', '概要')}}
            {{Form::textarea('detail', $task['detail'], ['placeholder' => '詳細を入力'])}}
            {{Form::label('reference', '参考')}}
            {{Form::textarea('reference', $task['reference'], ['placeholder' => '参考文献を入力'])}}

            {{Form::submit('編集', ['class' => ''])}}
            {{Form::close()}}
        @else
            <ul>
                <li>{{$task['summary']}}</li>
                <li>概要：{{$task['detail']}}</li>
                <li>参考</li>
                <li>{{$task['reference']}}</li>
            </ul>
        @endif
        <div>
            @if($task["is_delete"] === 0)
                {{Form::open( ['method' => 'DELETE', 'url' => 'task/'.$task['id']]) }}
                {{Form::submit('完了', ['class' => 'btn btn-danger'])}}
                {{Form::close()}}
            @else
                完了済
            @endif
        </div>
    </div>
</div>
