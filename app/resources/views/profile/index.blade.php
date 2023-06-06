@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="mt-5">
                @include('user.partials.userblock')
                <hr>
                @if(!$statuses->count())
                    <p>У {{$user->getFirstNameOrUsername()}} ничего не опубликовано</p>
                @else
                    @foreach($statuses as $status)
                        <div class="media">
                            <a class="mr-3" href="{{route('profile.index', ['username'=>$status->user->username])}}">
                                <img class="media-object rounded"
                                     src="{{$status->user->getAvatarUrl()}}"
                                     alt="{{$status->user->getNameOrUsername()}}">
                            </a>
                            <div class="media-body">
                                <h4>
                                    <a href="{{route('profile.index', ['username'=>$status->user->username])}}">
                                        {{$status->user->getNameOrUsername()}}
                                    </a>
                                </h4>
                                <p>{{$status->body}}</p>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        {{$status->created_at->diffForHumans()}}
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="">Лайк</a>
                                    </li>
                                    <li class="list-inline-item">
                                        10 лайков
                                    </li>
                                </ul>

                                <div class="mb-3 ml-10">
                                    @foreach($status->replies as $reply)
                                        <div class="media d-flex p-3 border">
                                            <a class="mr-3" href="{{route('profile.index', ['username'=>$reply->user->username])}}">
                                                <img class="media-object rounded"
                                                     src="{{$reply->user->getAvatarUrl()}}"
                                                     alt="{{$reply->user->getNameOrUsername()}}">
                                            </a>
                                            <div class="media-body pl-10">
                                                <h4>
                                                    <a href="{{route('profile.index', ['username'=>$reply->user->username])}}">
                                                        {{$reply->user->getNameOrUsername()}}
                                                    </a>
                                                </h4>
                                                <p>{{$reply->body}}</p>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        {{$reply->created_at->diffForHumans()}}
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="">Лайк</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        10 лайков
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($authUserIsFriend || Auth::user()->id === $status->user->id)
                                    <form method="post"
                                          action="{{route('status.reply', ['statusId' => $status->id])}}"
                                          class="mb-4">
                                        @csrf
                                        <div class="form-group">
                                        <textarea name="reply-{{$status->id}}" rows="3"
                                                  class="form-control {{$errors->has("reply-{$status->id}") ? 'is-invalid' : ''}}"
                                                  placeholder="Прокомментировать."></textarea>
                                            @if($errors->has("reply-{$status->id}"))
                                                <div class="invalid-feedback">
                                                    {{$errors->first("reply-{$status->id}")}}
                                                </div>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">Прокомментировать</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
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
