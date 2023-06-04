@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="mt-5">
                @include('user.partials.userblock')
                @if($user->location)
                    <p class="mt-0">Город: {{$user->location}}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
