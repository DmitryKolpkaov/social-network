@if(!$reply->user->avatar)
    <img class="media-object radius-50 w-10" src="{{$reply->user->getAvatarUrl()}}" alt="ava">
@else
    <img class="media-object radius-50 w-10" src="{{$reply->user->getAvatarsPath($reply->user->id). $reply->user->avatar}}" alt="ava">
@endif
