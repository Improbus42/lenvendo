@extends('layout.app')
@section('content')
    <style>
        .row-fluid {
            display: flex;
            justify-content: center;
        }
    </style>
    <div class="m-3"><a href="/bookmarks/desc">Список закладок</a></div>
    <div class="m-3"><a href="/export">Скачать Excel</a></div>
    <div class="row-fluid">
        <form action="/p" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <label for="url" class="col-form-label text-md-center">
                    URL страницы</label>
                <input id="url" type="text" name="url"
                       class="form-control @error('url') is-invalid @enderror @if(session()->has('error') || session()->has('valid')) is-invalid @endif"
                       value="{{ old('url') }}" autocomplete="url" autofocus>
                @error('url')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
                @if(session()->has('valid'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ session()->get('valid') }}</strong>
                        </span>
                @endif
                @if(session()->has('error'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ session()->get('error') }}</strong>
                        </span>
                @endif
            </div>

            <div class="row mt-2">
                <button class="btn btn-primary">Добавить</button>
            </div>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </form>
    </div>
@endsection
