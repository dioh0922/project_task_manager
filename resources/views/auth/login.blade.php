<div>
    <header>
        @include('header')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
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
