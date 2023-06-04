<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">Social</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if(\Illuminate\Support\Facades\Auth::check())
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Стена</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Друзья</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Поиск..." aria-label="Search">
                    <button class="btn btn-success" type="submit">Найти</button>
                </form>
            @endif
            <ul class="navbar-nav ml-auto">
                @if(Auth::check())
                    <li class="nav-item"><a href="" class="nav-link">{{\Illuminate\Support\Facades\Auth::user()->getNameOrUserName()}}</a></li>
                    <li class="nav-item"><a href="" class="nav-link">Обновить профиль</a></li>
                    <li class="nav-item"><a href="" class="nav-link">Выйти</a></li>
                @else
                    <li class="nav-item"><a href="" class="nav-link">Зарегистрироваться</a></li>
                    <li class="nav-item"><a href="" class="nav-link">Войти</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
