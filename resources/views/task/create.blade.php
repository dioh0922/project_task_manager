<div>
    <header>
        @include('header')
    </header>
    <div>
        @include('error')
    </div>
    <div @class([
        'container',
        'd-flex',
        'align-items-center',
        'justify-content-center'
    ])>
        <div>
            {{Form::open(['method' => 'POST', 'url' => 'task/'])}}
            {{Form::token()}}
            <div class='row'>
                {{Form::label('summary', 'タイトル')}}
                {{Form::text('summary', old('summary'), ['placeholder' => 'テーマの概要を入力'])}}
            </div>
            <div class='row'>
                {{Form::label('detail', '概要')}}
                {{Form::textarea('detail', old('detail'), ['placeholder' => '詳細を入力'])}}
            </div>
            <div class='row'>
                {{Form::label('reference', '参考')}}
                {{Form::text('reference', old('reference'), ['placeholder' => '参考文献を入力', 'class' => 'mb-4'])}}
            </div>
            <div class='row'>
                {{Form::submit('作成', ['class' => 'btn btn-primary'])}}
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
