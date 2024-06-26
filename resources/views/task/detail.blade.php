<div>
    <header>
        @include('header')
    </header>

    <div @style(['height: 80%']) @class([
        'container',
        'align-items-center',
        'justify-content-center'
    ])>
        <div class="container">
            <button type="button" class="btn btn-small btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#relationModal">関連しているもの</button>
            <div class="modal fade" tabindex="-1" id="relationModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <button class="btn btn-secondary my-2" onclick="location.href = '{{route('relation.show', ['relation' => $task['id']])}}'">
                                        関係タスクの設定
                                    </button>
                                </div>
                                <div>
                                    <p>親タスク</p>
                                    <ul>
                                        @foreach($parent as $parent_task)
                                            <li>
                                                <a href="{{route('task.show', ['task' => $parent_task['base_task_id']])}}" >
                                                    {{$parent_task['parent']['summary']}}：{{$parent_task['parent']['detail']}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <p>子タスク</p>
                                <ul>
                                    @foreach($child as $child_task)
                                        <li>
                                            <a href="{{route('task.show', ['task' => $child_task['child_task_id']])}}" >
                                                {{$child_task['child']['summary']}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='row'>
                <h3>{{$task['summary']}}</h3>
            </div>
            @if($task["is_delete"] === 0)
                {{Form::open(['method' => 'PUT', 'url' => 'task/'.$task['id']])}}
                {{Form::token()}}
                <div class='row h-50'>
                    <div class='col-6 border'>
                        {{Form::label('detail', '概要')}}
                        {{Form::textarea('detail', $task['detail'], ['placeholder' => '詳細を入力', 'style' => 'width:100%'])}}
                    </div>
                    <div class='col-6 h-50'>
                        <div class='my-1'>
                            {{Form::label('reference', '参考')}}
                        </div>
                        <div class='overflow-auto h-75 border'>
                            <ul>
                                @foreach($reference as $source)
                                    <li>{{$source['source']}}：{{$source['updated_at']}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class='my-1'>
                            {{Form::text('reference', null, ['placeholder' => '参考文献を入力'])}}
                        </div>

                        <div class='my-1'>
                            {{Form::label('comment', '検討メモ')}}
                        </div>
                        <div class='overflow-auto h-75 border'>
                            <ul>
                                @foreach($comment as $memo)
                                    <li>{{$memo['comment']}}：{{$memo['updated_at']}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class='my-1'>
                            {{Form::text('comment', null, ['placeholder' => '検討内容を記入'])}}
                        </div>
                    </div>

                <div class='row mt-2'>
                    {{Form::submit('編集', ['class' => 'btn btn-primary mt-4'])}}
                </div>
                {{Form::close()}}
            @else
                <div class='row'>
                    <div class='col-6'>
                        概要<br>
                        <div @style([
                            'white-space: pre-wrap',
                            'word-wrap:break-word'
                        ])>{{$task['detail']}}</div>
                    </div>
                    <div class='col-6'>
                        参考<br>
                        @foreach($reference as $source)
                            <div class='text-break mb-1 border-bottom border-secondary'>
                                {{$source['source']}}
                            </div>
                        @endforeach

                        メモ<br>
                        @foreach($comment as $memo)
                            <div class='text-break mb-1 border-bottom border-secondary'>
                                {{$memo['comment']}}：{{$memo['updated_at']}}
                            </div>
                        @endforeach
                    </div>
                </div>
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
