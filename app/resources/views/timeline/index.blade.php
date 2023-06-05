@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6 mt-5">
            <form method="post" action="{{route('status.post')}}">
                @csrf
                <div class="form-group">
                    <textarea name="status" class="form-control {{$errors->has('status') ? 'is-invalid' : ''}}"
                              placeholder="Что у вас нового {{Auth::user()->getFirstNameOrUsername()}}?" rows="3"></textarea>
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
                            <form method="post" action="" class="mb-4">
                                @csrf
                                <div class="form-group">
                                    <textarea name="status" rows="3" class="form-control" placeholder="Прокоментировать"></textarea>
                                </div>
                                <input type="submit" class="btn btn-primary btn-sm mt-3" value="Ответить">
                            </form>
                        </div>
                    </div>
                @endforeach
                {{$statuses->links()}}
            @endif
        </div>
    </div>
@endsection
