<nav class='navbar navbar-expand bg-success' data-bs-theme='dark'>
  <div class='container-fluid'>

    <div class='collapse navbar-collapse' id='navbar'>

      <ul class='navbar-nav'>
        <li class='nav-item'>
          <button class='nav-link' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span class="navbar-toggler-icon"></span></button>
          <ul class='dropdown-menu'>
            <li><a class='dropdown-item' href="{{route('task.index')}}">一覧へ</a></li>
            <li><a class='dropdown-item' href="{{route('analyze.index')}}">分析</a></li>
            <li><a class='dropdown-item' href="{{route('task.create')}}">新規作成</a></li>
            <li><a class='dropdown-item' href="{{route('logout')}}">ログアウト</a></li>
          </ul>
        </li>
      </ul>

      <div class='mx-auto align-items-center'>
        <div class='text-white'>
          {{$title}}
        </div>
      </div>

    </div>
  </div>
</nav>
