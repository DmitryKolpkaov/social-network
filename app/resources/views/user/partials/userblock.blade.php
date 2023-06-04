<div class="media">
{{--    <img src="/" alt="ava">--}}
    <div class="media-body">
        <h5 class="mt-0">
            <a href="">{{$user->getNameOrUsername()}}</a>
        </h5>
        @if($user->location)
            <h6>{{$user->location}}</h6>
        @endif
    </div>
</div>
