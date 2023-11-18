<div>
    <header>
        @include('header')
    </header>
    <div @style([
        'margin: auto',
    ])>
        <p>{{$task["summary"]}}</p>
        <textarea name="" id="" cols="30" rows="10">{{$task["detail"]}}</textarea>
        <div>
            {{Form::open( ['method' => 'DELETE', 'url' => 'task/'.$task["id"]]) }}
            {{Form::submit('完了', ['class' => 'btn btn-danger'])}}
            {{Form::close()}}
        </div>
    </div>
</div>
