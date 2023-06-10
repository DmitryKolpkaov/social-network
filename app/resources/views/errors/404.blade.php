@extends('templates.default')
{{--Страница ошибки--}}
@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <h3 class="mt-5">Ошибка 404</h3>
            <p>Страница не найдена, вернитесь на главную!</p>
            <a href="{{route('home')}}" class="btn btn-primary">Вернуться на главную</a>
        </div>
    </div>
@endsection
