<div>
    <header>
        @include('header')
    </header>

    <div @class([
        'container',
        'align-items-center',
        'justify-content-center'
    ])>
        <div>
            <div class='row'>    
                <p>{{$task['summary']}}</p>
            </div>
            @if($task["is_delete"] === 0)
                {{Form::open(['method' => 'PUT', 'url' => 'task/'.$task['id']])}}
                {{Form::token()}}
                <div class='row'>
                    <div class='col-6'>
                        {{Form::label('detail', '概要')}}
                        {{Form::textarea('detail', $task['detail'], ['placeholder' => '詳細を入力', 'style' => 'width:100%'])}}
                    </div>
                    <div class='col-6'>
                        <div class=''>
                            {{Form::label('reference', '参考')}}
                            <ul>
                                @foreach($reference as $source)
                                    <li>{{$source['source']}}：{{$source['updated_at']}}</li>
                                @endforeach
                            <li>{{Form::text('reference', null, ['placeholder' => '参考文献を入力'])}}</li>
                            </ul>
                        </div>
                        <div>
                            {{Form::label('comment', '検討メモ')}}
                            <ul>
                                @foreach($comment as $content)
                                    <li>{{$content['comment']}}：{{$content['updated_at']}}</li>
                                @endforeach
                            <li>{{Form::text('comment', null, ['placeholder' => '検討内容を記入'])}}</li>
                            </ul>
                        </div>
                    </div>

                <div class='row'>
                    {{Form::submit('編集', ['class' => 'btn btn-primary mt-4'])}}
                </div>
                {{Form::close()}}
            @else
                <ul>
                    <li>{{$task['summary']}}</li>
                    <li>完了日：{{$task['closed_at']}}</li>
                    <li>概要：{{$task['detail']}}</li>
                    <li>参考</li>
                    <li>{{$task['reference']}}</li>
                </ul>
            @endif

        @if($task["is_delete"] === 0)
            {{Form::open( ['method' => 'DELETE', 'url' => 'task/'.$task['id'], 'class' => 'row']) }}
            {{Form::submit('完了', ['class' => 'btn btn-secondary mt-4'])}}
            {{Form::close()}}
        @else
            完了済
        @endif

        </div>
    </div>
</div>
