@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <h3 class="mt-5">Войти</h3>
            <form method="post" action="{{route('auth.signin')}}" novalidate>
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
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                    <label class="custom-control-label" for="remember">Запомнить</label>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>
    </div>
@endsection
