@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3 class="mt-5">Результаты поиска: "{{Request::input('query')}}"</h3>

            @if(!$users->count())
                <p>Пользователеь не найден</p>
            @else
                <div class="row">
                    <div class="col-lg-4">
                        @foreach($users as $user)
                            @include('user.partials.userblock')
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
