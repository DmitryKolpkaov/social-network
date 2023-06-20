@extends('templates.default')
{{--Вывод всех записей и комментариев на стене и главной странице--}}
@section('content')
    <div class="row">
        <div class="col-lg-6 mt-5">
            {{--Создание записи--}}
            <form method="post" action="{{route('status.post')}}">
                @csrf
                <div class="form-group">
                    <textarea name="status" class="form-control {{$errors->has('status') ? 'is-invalid' : ''}}"
                              placeholder="Что у вас нового {{Auth::user()->getFirstNameOrUsername()}}?"
                              rows="3"></textarea>
                    @if($errors->has('status'))
                        <div class="invalid-feedback">
                            {{$errors->first('status')}}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Опубликовать</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <hr>
            @if(!$statuses->count())
                <p>Нет не одной записи на стене.</p>
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
                                                 fill="currentColor" class="bi bi-chat-heart-fill" viewBox="0 0 16 16">
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
                                                    <li class="list-inline-item" data-bs-placement="top" title="Like">
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
                            {{--Оставляем комментарий--}}
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
                        </div>
                    </div>
                @endforeach
                {{--Пагинация 10 записей на странице--}}
                {{$statuses->links()}}
            @endif
        </div>
    </div>
@endsection
