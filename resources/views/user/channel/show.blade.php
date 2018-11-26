@extends('layouts.user')

@section('content')

    {{--navigator section--}}
    <div class="card mb-4">
        <div class="card-header bg-success border-success">
            <div>
                <a href="{{ url('/channel') }}">Tất cả đề mục</a>
                <i class="fas fa-chevron-right ml-3 mr-2"></i>
                <a href="{{ url('/channel/'.$channel->slug) }}">{{ $channel->name }}</a>
                @if (isset($topic))
                    <i class="fas fa-chevron-right ml-3 mr-2"></i>
                    <a href="{{ url('/channel/topic/'.$topic->slug) }}">{{ $topic->name }}</a>
                @endif
            </div>
            <div>
                @if (isset($topics))
                    @foreach($topics as $d)
                        <a class="mr-2" href="{{ url('/channel/topic/'.$d->slug) }}">{{ $d->name }}</a>
                    @endforeach
                @else
                    <a class="mr-2" href="?order=created_at">Mới nhất</a>
                    <a class="mr-2" href="?order=updated_at">Cập nhật</a>
                    <a class="mr-2" href="?order=views">Lượt xem</a>
                    <a class="mr-2" href="?order=replies">Bình luận</a>
                    <a class="mr-2" href="?order=bookmarks">Theo dõi</a>
                @endif
            </div>
        </div>
    </div>

    @if (isset($topic))
        <div class="mb-4">
            @if ($topic->bookmarked)
                {!! Form::open(['route' => ['user.topic.bookmark', $topic->id], 'method' => 'POST']) !!}
                <button class="btn btn-lg btn-deep-orange ml-0 mr-2 ml-0">Đang theo dõi</button>
                <a class="btn btn-lg btn-primary ml-0 mr-2" href="{{ url('/discussion/topic/'.$topic->slug) }}">Thảo luận mới</a>
                <a class="btn btn-lg btn-mdb-color mb-1 ml-0 mr-0 float-sm-right" href="{{ url('/channel/'.$channel->slug) }}"><i class="fas fa-arrow-left mr-2"></i>Đề mục</a>
                {!! Form::close() !!}
            @else
                {!! Form::open(['route' => ['user.topic.bookmark', $topic->id], 'method' => 'POST']) !!}
                <button class="btn btn-lg btn-orange ml-0 mr-2 mb-1">Theo dõi</button>
                <a class="btn btn-lg btn-primary ml-0 mr-2 mb-1" href="{{ url('/discussion/topic/'.$topic->slug) }}">Thảo luận mới</a>
                <a class="btn btn-lg btn-mdb-color ml-0 mr-0 float-sm-right" href="{{ url('/channel/'.$channel->slug) }}"><i class="fas fa-arrow-left mr-2"></i>Đề mục</a>
                {!! Form::close() !!}
            @endif
        </div>
    @endif

    {{--discussions section--}}
    @if(isset($items))
        @foreach($items as $d)
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2 d-md-table d-none text-center">
                            @if(isset($d->user->photo) && $d->user->photo != '')
                                <img class="img-fluid rounded-circle" style="width: 100%; max-width: 80px; max-height: 80px"
                                     src="{{ url('storage/img/user/'.$d->user->photo)}}" alt="{{$d->user->photo}}">
                            @endif
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="mb-2"><a class="h3" href="{{ url('/discussion/'.$d->slug) }}">{{ $d->title }}</a>
                            <p class="mb-0">{{ $d->user->name }} trong mục <a href="{{ url('/channel/topic/'.$d->topic->id) }}">{{ $d->topic->name }}</a> lúc {{ $d->created_at }} đạt {{ $d->views }} lượt xem.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body img-hidden text-justify">{!! $d->content !!}</div>
            </div>
        @endforeach
        <div class="row mt-3"><div class="mx-auto">{{ $items->appends(request()->except('page'))->links() }}</div></div>
    @endif
@endsection

