@extends('templates.default')

@section('content')
    <div class="row">
        <div class="">
            <h3 class="mt-5">Результаты поиска: "{{Request::input('query')}}"</h3>
            @if(!$users->count())
                <p>Пользователь не найден</p>
            @else
                <div class="">
                    @foreach($users as $user)
                        @include('user.partials.userblock')
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
