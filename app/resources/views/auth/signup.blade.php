@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <h3 class="mt-5">Регистрация</h3>
            <form method="post" action="{{route('auth.signup')}}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Почта</label>
                    <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                           id="email" name="email"
                           placeholder="Введите ваш email" value="{{Request::old('email') ? : ''}}">
                    @if($errors->has('email'))
                        <span class="help-block text-danger">
                            {{$errors->first('email')}}
                        </span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Логин</label>
                    <input type="text" class="form-control {{$errors->has('username') ? 'is-invalid' : ''}}"
                           id="username" name="username"
                           placeholder="Введите ваш логин" value="{{Request::old('username') ? : ''}}">
                    @if($errors->has('username'))
                        <span class="help-block text-danger">
                            {{$errors->first('username')}}
                        </span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                           id="password" name="password"
                           placeholder="Минимум 8 символов">
                    @if($errors->has('password'))
                        <span class="help-block text-danger">
                            {{$errors->first('password')}}
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Создать аккаунт</button>
            </form>
        </div>
    </div>
@endsection
