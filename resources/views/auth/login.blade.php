<div>
    <header>
        @include('header')
    </header>
    <h1>{{$check}}</h1>
    @guest
        {{Form::open(['method' => 'POST', 'url' => '/login'])}}
        {{Form::token()}}
        {{Form::label('userID', 'ユーザーID')}}
        {{Form::text('userID', null)}}
        {{Form::label('', '')}}
        {{Form::password('password', null)}}
        {{Form::submit('ログイン')}}
        {{Form::close()}}
    @endguest

    @auth
        ログイン済
    @endauth
</div>
