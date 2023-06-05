@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <h3 class="mt-5">Ваши друзья:</h3>
            @if(!$friends->count())
                <p>У вас нет друзей</p>
            @else
                @foreach($friends as $user)
                    @include('user.partials.userblock')
                @endforeach
            @endif
        </div>
        <div class="col-lg-6 mx-auto">
            <h3 class="mt-5">Запросы в друзья:</h3>
        </div>
    </div>
@endsection
