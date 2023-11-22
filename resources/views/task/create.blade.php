<div>
    <header>
        @include('header')
        @include('back_to_list')
    </header>
    <div>
        @include('error')
    </div>
    <div @style([
        'margin: auto',
    ])>
        {{Form::open(['method' => 'POST', 'url' => 'task/'])}}
        {{Form::token()}}
        {{Form::label('summary', 'タイトル')}}
        {{Form::text('summary', old('summary'), ['placeholder' => 'テーマの概要を入力'])}}
        {{Form::label('detail', '概要')}}
        {{Form::textarea('detail', old('detail'), ['placeholder' => '詳細を入力'])}}
        {{Form::label('reference', '参考')}}
        {{Form::textarea('reference', old('reference'), ['placeholder' => '参考文献を入力'])}}
        {{Form::submit('作成', [])}}
        {{Form::close()}}
    </div>
</div>
