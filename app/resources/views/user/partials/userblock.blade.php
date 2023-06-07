{{--Профиль пользователя, его аватар, имя и локация--}}
<div class="media">
    <div class="media-body">
        <a href="{{route('profile.index', ['username'=>$user->username])}}">
            <img class="" src="{{$user->getAvatarUrl()}}" alt="ava">
        </a>
        <h5 class="mt-0 mb-3">
            <a href="{{route('profile.index', ['username'=>$user->username])}}">{{$user->getNameOrUsername()}}</a>
        </h5>
        @if($user->location)
            <p class="mt-0 h6"><span class="h5">Локация: </span>{{$user->location}}</p>
        @endif
    </div>
</div>
