@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="mt-5">
                @include('user.partials.userblock')
            </div>
        </div>
        <div class="col-lg-4 col-lg-offset-3 mt-3">
{{--            <h4>Друзья {{$user->getFirstNameOrUsername()}}</h4>--}}
{{--            @if(!$user->friends()->count())--}}
{{--                <p>Нет друзей у {{$user->getFirstNameOrUsername()}}</p>--}}
{{--            @else--}}
{{--                @foreach($user->friends() as $user)--}}
{{--                    @include('user.partials.userblock')--}}
{{--                @endforeach--}}
{{--            @endif--}}
        </div>
    </div>
@endsection
