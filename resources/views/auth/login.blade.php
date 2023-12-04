<div>
    <header>
        @include('header')
    </header>
    <h1>{{$check}}</h1>
    @guest
    <div class='container d-flex align-items-center justify-content-center'>
        {{Form::open(['method' => 'POST', 'url' => '/login'])}}
        {{Form::token()}}
        <div class='row'>
            {{Form::label('userID', 'ユーザーID')}}
            {{Form::text('userID', null, ['class' => 'form-control mb-4'])}}
        </div>
        <div class='row'>
            {{Form::label('password', 'パスワード')}}
            {{Form::password('password', ['class' => 'form-control mb-4'])}}
        </div>
        <div class='row'>
            {{Form::submit('ログイン', ['class' => 'btn btn-success btn-block md-4'])}}
        </div>

        {{Form::close()}}
    </div>
    @endguest

    @auth
        ログイン済
    @endauth
</div>
