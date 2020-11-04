@extends('layout.app')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <style>
        .row-fluid {
            display: flex;
            justify-content: center;
        }
    </style>
    <div class="m-3"><a href="/">Основная страница</a></div>
    <div class="m-3"><a href="/bookmarks/desc">Список закладок</a></div>

    <div class="row-fluid">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{$values->url}}">{{$values->url}}</a></li>
            <li class="list-group-item">Дата добавления: {{$values->created_at}}</li>
            <li class="list-group-item"><a href="{{$values->favicon}}" target="_blank">Посмотреть favicon</a></li>
            <li class="list-group-item">Заголовок: {{$values->title}}</li>
            <li class="list-group-item">META Keywords: {{$values->meta_key}}</li>
            <li class="list-group-item">META Description: {{$values->meta_desc}}</li>
        </ul>
    </div>
    {{--    <div class="btn btn-danger ml-2">--}}
    {{--        <a style="text-decoration:none;color: white;" href="/delete/{{$values->id}}">Удалить закладку</a></div>--}}
    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
        Удалить закладку
    </a>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Подтверждение удаления</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/delete/{{$values->id}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="password" class="col-form-label text-md-center">
                            Введите пароль </label>
                        <input id="password" type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror @if(session()->has('errorPassword')) is-invalid @endif"
                               autocomplete="password" autofocus>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @if(session()->has('errorPassword'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ session()->get('errorPassword') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                        <button type="submit" name="button1" class="btn btn-danger">Подтвердить удаление</button>
                    </div>
                    <input type="hidden" name="id_hid" value="{{$values->id}}"/>
                </form>
            </div>
        </div>
    </div>
@endsection
