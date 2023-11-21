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
        {{Form::label('summary', 'タイトル')}}
        {{Form::text('summary', null, ['placeholder' => 'テーマの概要を入力'])}}
        {{Form::label('detail', '概要')}}
        {{Form::textarea('detail', null, ['placeholder' => '詳細を入力'])}}
        {{Form::label('reference', '参考')}}
        {{Form::textarea('reference', null, ['placeholder' => '参考文献を入力'])}}
        {{Form::submit('作成', [])}}
        {{Form::close()}}
    </div>
</div>
