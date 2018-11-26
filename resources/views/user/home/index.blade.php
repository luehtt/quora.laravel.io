@extends('layouts.user')

@section('content')

    {{--views section--}}
    @if(isset($views))
        <div class="card mb-4">
            <div class="card-header">Thảo luận phổ biến
                <p class="mb-0 float-md-right"><a href="{{ url('/top?view=latest') }}">Tất cả</a></p>
            </div>
            <div class="card-body text-justify">
                @foreach($views as $d)
                    <div class="row">
                        <div class="col-6 col-sm-3">{{ $d->user->name }}</div>
                        <div class="col-6 col-sm-3">{{ date($d->created_at) }}</div>
                        <div class="col-12 col-sm-6 text-truncate"><a href={{ url('/discussion/'.$d->slug) }}>{{ $d->title }}</a></div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{--replies section--}}
    @if(isset($replies))
        <div class="card mb-4">
            <div class="card-header">Thảo luận nổi bật
                <p class="mb-0 float-md-right"><a href="{{ url('/top?view=views') }}">Tất cả</a></p>
            </div>
            <div class="card-body text-justify">
                @foreach($replies as $d)
                    <div class="row">
                        <div class="col-6 col-sm-3">{{ $d->user->name }}</div>
                        <div class="col-6 col-sm-3">{{ $d->created_at }}</div>
                        <div class="col-12 col-sm-6 text-truncate"><a href={{ url('/discussion/'.$d->slug) }}>{{ $d->title }}</a></div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{--bookmarked section--}}
    @if(isset($bookmarked))
        <div class="card mb-4">
            <div class="card-header">Thảo luận đang theo dõi
                <p class="mb-0 float-md-right"><a href="{{ url('/bookmark?view=bookmarked') }}">Tất cả</a></p>
            </div>
            <div class="card-body text-justify">
                @foreach($bookmarked as $d)
                    <div class="row">
                        <div class="col-6 col-sm-3">{{ $d->user->name }}</div>
                        <div class="col-6 col-sm-3">{{ $d->created_at }}</div>
                        <div class="col-12 col-sm-6 text-truncate"><a href={{ url('/discussion/'.$d->slug) }}>{{ $d->title }}</a></div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{--discussions section--}}
    @if(isset($discussions))
        <div class="card mb-4">
            <div class="card-header">Thảo luận đã tạo
                <p class="mb-0 float-md-right"><a href="{{ url('/bookmark?view=posted') }}">Tất cả</a></p>
            </div>
            <div class="card-body text-justify">
                @foreach($discussions as $d)
                    <div class="row">
                        <div class="col-6 col-sm-3">{{ $d->user->name }}</div>
                        <div class="col-6 col-sm-3">{{ $d->created_at }}</div>
                        <div class="col-12 col-sm-6 text-truncate"><a href={{ url('/discussion/'.$d->slug) }}>{{ $d->title }}</a></div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection