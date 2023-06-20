@if(!$status->user->avatar)
    <img class="media-object radius-50 w-10" src="{{$status->user->getAvatarUrl()}}" alt="ava">
@else
    <img class="media-object radius-50 w-10" src="{{$status->user->getAvatarsPath($status->user->id). $status->user->avatar}}" alt="ava">
@endif
