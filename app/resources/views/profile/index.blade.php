@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="mt-5">
                @include('user.partials.userblock')
            </div>
        </div>
        <div class="col-lg-4 col-lg-offset-3 mt-3">
            @if(Auth::user()->hasFriendRequestPending($user))
                <p class="mt-5">
                    В ожидании {{$user->getFirstNameOrUsername()}} подтверждения запроса на дружбу.
                </p>
            @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="{{route('friend.accept', ['username'=>$user->username])}}"
                   class="btn btn-primary mt-5">Подтвердить дружбу.
                </a>
            @elseif(Auth::user()->isFriendWith($user))
                <div class="mt-3">
                    {{$user->getFirstNameOrUsername()}} у вас в друзьях.
                    <form action="{{route('friend.delete', ['username'=>$user->username])}}"
                          method="post">
                        @csrf
                        <input type="submit" class="btn btn-primary my-2" value="Удалить из друзей">
                    </form>
                </div>
            @elseif(Auth::user()->id !== $user->id)
                <a href="{{route('friend.add', ['username'=>$user->username])}}"
                   class="btn btn-primary mt-5">Добавить в друзья.
                </a>
            @endif

            @if(Auth::user()->id !== $user->id)
                <h4>Друзья {{$user->getFirstNameOrUsername()}}</h4>
                @if(!$user->friends()->count())
                    <p>Нет друзей у {{$user->getFirstNameOrUsername()}}</p>
                @else
                    @foreach($user->friends() as $user)
                        @include('user.partials.userblock')
                    @endforeach
                @endif
            @endif
        </div>
    </div>
@endsection
