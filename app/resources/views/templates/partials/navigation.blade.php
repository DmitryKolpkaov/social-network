<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">Social</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="flex-grow: 0!important;">
            @if(Auth::check())
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Стена</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Друзья</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" method="get" action="{{route('search.results')}}">
                    <input name="query" class="form-control me-2" type="search" placeholder="Поиск..." aria-label="Search">
                    <button class="btn btn-success" type="submit">Найти</button>
                </form>
            @endif
            <ul class="navbar-nav ml-auto">
                @if(Auth::check())
                    <li class="nav-item">
                        <a href="{{route('profile.index', ['username'=> Auth::user()->username])}}"
                           class="nav-link">{{Auth::user()->getNameOrUsername()}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Обновить профиль</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('auth.signout')}}" class="nav-link">Выйти</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{route('auth.signup')}}" class="nav-link">Зарегистрироваться</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('auth.signin')}}" class="nav-link">Войти</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
