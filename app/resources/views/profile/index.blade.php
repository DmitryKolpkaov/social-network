@extends('templates.default')
{{--Посты на странице профиля.--}}
@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="mt-5">
                @include('user.partials.userblock')
                <hr>
                @if(Auth::user()->id === $user->id)
                    <form action="{{route('upload-avatar', ['username' => Auth::user()->username])}}" enctype="multipart/form-data" method="post" class="my-2">
                        @csrf
                        <label for="avatar" class="mb-1">Загрузить аватар</label>
                        <input type="file" name="avatar" id="avatar" class="d-block mb-3">
                        <input type="submit" value="Загрузить" class="btn btn-primary">
                    </form>
                    <hr>
                @endif
                {{--Если не создал запись на стене, она не отобразится--}}
                @if(!$statuses->count())
                    <p>У {{$user->getFirstNameOrUsername()}} ничего не опубликовано</p>
                @else
                    {{--Перебор записей--}}
                    @foreach($statuses as $status)
                        <div class="media">
                            <a class="mr-3" href="{{route('profile.index', ['username'=>$status->user->username])}}">
                                @include('user.partials.avatar')
                            </a>
                            <div class="media-body">
                                <h4>
                                    <a href="{{route('profile.index', ['username'=>$status->user->username])}}">
                                        {{$status->user->getNameOrUsername()}}
                                    </a>
                                </h4>
                                <p>{{$status->body}}</p>
                                <ul class="list-inline border pl-10">
                                    <li class="list-inline-item">
                                        {{$status->created_at->diffForHumans()}}
                                    </li>
                                    @if($status->user->id !== Auth::user()->id)
                                        <li class="list-inline-item" data-bs-placement="top" title="Like">
                                            <a href="{{route('status.like', ['statusId'=>$status->id])}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-chat-heart-fill"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9.06 9.06 0 0 0 8 15Zm0-9.007c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
                                                </svg>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="list-inline-item pl-10">
                                        {{$status->likes()->count()}} {{Str::plural('like', $status->likes()->count())}}
                                    </li>
                                </ul>

                                {{--Удаление записи--}}
                                @if($status->user->id === Auth::user()->id)
                                    <a class="btn btn-primary mb-3"
                                       href="{{route('status.delete', ['statusId'=> $status->id])}}">
                                        Delete
                                    </a>
                                @endif

                                <div class="mb-3 ml-10">
                                    {{--Перебор комментариев--}}
                                    @foreach($status->replies as $reply)
                                        <div class="media d-block p-3 border">
                                            <a class="mr-3"
                                               href="{{route('profile.index', ['username'=>$reply->user->username])}}">
                                                @include('user.partials.avatar-reply')
                                            </a>
                                            <div class="media-body pl-10">
                                                <h4>
                                                    <a href="{{route('profile.index', ['username'=>$reply->user->username])}}">
                                                        {{$reply->user->getNameOrUsername()}}
                                                    </a>
                                                </h4>
                                                <p>{{$reply->body}}</p>
                                                <ul class="list-inline border pl-10">
                                                    <li class="list-inline-item">
                                                        {{$reply->created_at->diffForHumans()}}
                                                    </li>
                                                    {{--Ставим лайки--}}
                                                    @if($reply->user->id !== Auth::user()->id)
                                                        <li class="list-inline-item" data-bs-placement="top"
                                                            title="Like">
                                                            <a href="{{route('status.like', ['statusId'=>$reply->id])}}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" fill="currentColor"
                                                                     class="bi bi-chat-heart-fill" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9.06 9.06 0 0 0 8 15Zm0-9.007c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
                                                                </svg>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li class="list-inline-item pl-10">
                                                        {{$reply->likes()->count()}} {{Str::plural('like', $reply->likes()->count())}}
                                                    </li>
                                                </ul>

                                                {{--Удаление комментария--}}
                                                @if($reply->user->id === Auth::user()->id)
                                                    <a class="btn btn-primary"
                                                       href="{{route('reply.delete', ['statusId'=> $reply->id])}}">
                                                        Delete
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{--Если друг или пользователь создавший эту запись, то можно оставить комментарий--}}
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
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">Прокомментировать
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        {{--Дружба--}}
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
