@extends('layout.app')
@section('content')
    <style>
        .row-fluid {
            display: flex;
            justify-content: center;
        }
    </style>
    <div class="m-3"><a href="/">Основная страница</a></div>
    <select name="sel" onchange="if (this.value) window.location.href = this.value">
        <option value="#">Сортировка</option>
        <option value="/bookmarks/asc">Дата(по возрастанию)</option>
        <option value="/bookmarks/desc">Дата(по убыванию)</option>
        <option value="/bookmarks/urlAsc">URL(по возрастанию)</option>
        <option value="/bookmarks/urlDesc">URL(по убыванию)</option>
        <option value="/bookmarks/titleAsc">Заголовок(по возрастанию)</option>
        <option value="/bookmarks/titleDesc">Заголовок(по убыванию)</option>
    </select>
    @foreach ($values as $value)
        <div style="margin-top: 15px;" class="row-fluid">
            <ul class="list-group">
                <li class="list-group-item">Дата добавления: {{$value->created_at}}</li>
                <li class="list-group-item"><a href="{{$value->favicon}}" target="_blank">Посмотреть favicon</a></li>
                <li class="list-group-item"><a href="{{$value->url}}">{{$value->url}}</a></li>
                <li class="list-group-item">Заголовок: {{$value->title}}</li>
                <li class="list-group-item"><a href="/bookmark/{{$value->id}}">Детальная информация</a></li>
            </ul>
        </div>
    @endforeach
    <div class="row-fluid">{{ $values->links('paginate')}}</div>

    <style>
        .pagination li {
            list-style-type: none;
            float: left;
            margin-left: 10px;
        }

        .pagination li span {
            color: #000;
        }

        .pagination li a {
            color: #000;
            text-decoration: none;
        }
    </style>
@endsection
