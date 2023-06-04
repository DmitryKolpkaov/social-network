<div class="media">
    <div class="media-body">
        <a href="">
            <img class="" src="{{$user->getAvatarUrl()}}" alt="ava">
        </a>
        <h5 class="mt-0 mb-3">
            <a href="">{{$user->getNameOrUsername()}}</a>
        </h5>
        @if($user->location)
            <p class="mt-0">{{$user->location}}</p>
        @endif
    </div>
</div>
