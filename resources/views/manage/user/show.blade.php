@extends('layouts.admin')

@section('content')
    {{--discussion section--}}
    <div class="card mb-4">
        @if ($item->enabled) <div class="card-header bg-success">
        @else <div class="card-header bg-danger">
        @endif
            <div class="row">
                <div class="col-sm-2 d-sm-table d-none text-center">
                    @if(isset($item->photo) && $item->photo != '')
                        <img class="img-fluid rounded-circle w-100" style="max-width: 100px; max-height: 100px"
                             src="{{ url('storage/img/user/'.$item->photo)}}" alt="{{$item->photo}}">
                    @endif
                </div>
                <div class="col-sm-10 col-12 my-auto">
                    <h3 class="mb-2">{{ $item->name }}</h3>
                    <p class="mb-0">Email: {{ $item->email }}</p>
                    <p class="mb-0">Tham gia: {{ $item->created_at }}</p>
                    <p class="mb-0">Phân quyền: {{ $item->user_role->name }}</p>
                </div>
            </div>
        </div>

        <div class="card-body">
            <p class="mb-1">Tổng lượt tạo thảo luận: {{ $item->discussed }}
                <a class="float-md-right" href="?view=discussed">Xem</a></p>
            <p class="mb-1">Tổng lượt trả lời: {{ $item->replied }}
                <a class="float-md-right" href="?view=replied">Xem</a></p>
            <p class="mb-1">Tổng lượt thảo luận bị tố cáo: {{ $item->discussedReported }}
                <a class="float-md-right" href="?view=discussedReported">Xem</a></p>
            <p class="mb-1">Tổng lượt trả lời bị tố cáo: {{ $item->repliedReported }}
                <a class="float-md-right" href="?view=repliedReported">Xem</a></p>
            <div class="mt-2">
                @if(!$item->enabled)
                    {!! Form::open(['route' => ['user.enable', $item->id], 'method' => 'PUT']) !!}
                    <button class="btn btn-danger mb-1 ml-0">DISABLED</button>
                    <a class="btn btn-mdb-color float-md-right mb-1 mr-0" href="{{ url('/manage/user') }}">Trở lại</a>
                    {!! Form::close() !!}
                @else
                    {!! Form::open(['route' => ['user.enable', $item->id], 'method' => 'PUT']) !!}
                    <button class="btn btn-success mb-1 ml-0">ENABLED</button>
                    <a class="btn btn-mdb-color float-md-right mb-1 mr-0" href="{{ url('/manage/user') }}">Trở lại</a>
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>

    {{--discussions section--}}
    @if(isset($discussed))
        @foreach($discussed as $d)
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
                            <p class="mb-0">{{ $d->user->name }} trong mục
                                <a href="{{ url('/channel/topic/'.$d->topic->id) }}">{{ $d->topic->name }}</a>
                                lúc {{ $d->created_at }} đạt {{ $d->views }} lượt xem.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body img-hidden text-justify">{!! $d->content !!}</div>
            </div>
        @endforeach
        <div class="row mt-2"><div class="mx-auto">{{ $discussed->appends(request()->except('page'))->links() }}</div></div>
    @endif

    {{--discussion reports section--}}
    @if(isset($discussedReported))
        @foreach($discussedReported as $d)
            <div class="card mb-4">
                <div class="card-header bg-danger">
                    <div class="row">
                        <div class="col-md-2 d-md-table d-none text-center">
                            @if(isset($d->user->photo) && $d->user->photo != '')
                                <img class="img-fluid rounded-circle" style="width: 100%; max-width: 80px; max-height: 80px"
                                     src="{{ url('storage/img/user/'.$d->user->photo)}}" alt="{{$d->user->photo}}">
                            @endif
                        </div>
                        <div class="col-sm-10 col-12 my-auto">
                            <p class="mb-2"><a href="{{ url('/manage/member/'.$d->user->id) }}">{{ $d->user->name }}</a> tố cáo lúc {{ $d->created_at }}</p>
                            <p class="mb-2">Lí do: {{ $d->reason->name }}</p>
                            <p class="mb-0"><a href="{{ url('/discussion/'.$d->discussion->slug) }}">{{$d->discussion->title}}</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-body text-justify">{{ $d->content }}</div>
            </div>
        @endforeach
        <div class="row mt-2"><div class="mx-auto">{{ $discussedReported->appends(request()->except('page'))->links() }}</div></div>
    @endif

    {{--replied section--}}
    @if(isset($replied))
        @foreach($replied as $d)
            <div class="card mb-4">
                <div class="card-header bg-secondary">
                    <div class="row">
                        <div class="col-sm-2 d-sm-table d-none text-center">
                            @if(isset($d->user->photo) && $d->user->photo != '')
                                <img class="img-fluid rounded-circle w-100" style="max-width: 80px; max-height: 80px"
                                     src="{{ url('storage/img/user/'.$d->user->photo)}}" alt="{{$d->user->photo}}">
                            @endif
                        </div>
                        <div class="col-sm-10 col-12 my-auto">
                            <p class="mb-2">{{ $d->user->name }} trả lời lúc {{ $item->created_at }}</p>
                            <p class="mb-2"><a href="{{ url('/discussion/'.$d->discussion->slug) }}">{{ $d->discussion->title }}</a></p>
                            <p class="mb-0">Người tạo thảo luận: <a href="{{ url('/manage/user/'.$d->discussion->user->id) }}">{{$d->discussion->user->name}}</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-body text-justify">{!! $d->content !!}</div>
            </div>
        @endforeach
        <div class="row mt-2"><div class="mx-auto">{{ $replied->appends(request()->except('page'))->links() }}</div></div>
    @endif

    {{--replied reported section--}}
    @if(isset($repliedReported))
        @foreach($repliedReported as $d)
            <div class="card mb-4">
                <div class="card-header bg-danger">
                    <div class="row">
                        <div class="col-sm-2 d-sm-table d-none text-center">
                            @if(isset($d->user->photo) && $d->user->photo != '')
                                <img class="img-fluid rounded-circle w-100" style="max-width: 80px; max-height: 80px"
                                     src="{{ url('storage/img/user/'.$d->user->photo)}}" alt="{{$d->user->photo}}">
                            @endif
                        </div>
                        <div class="col-sm-10 col-12 my-auto">
                            <p class="mb-2"><a href="{{ url('/manage/member/'.$d->user->id) }}">{{ $d->user->name }}</a> tố cáo lúc {{ $d->created_at }}</p>
                            <p class="mb-2">Lí do: {{ $d->reason->name }}</p>
                            <p class="mb-0"><a href="{{ url('/discussion/'.$d->reply->discussion->slug) }}">{{$d->reply->discussion->title}}</a></p>
                        </div>
                    </div>
                </div>
                <div class="card-body text-justify">{{ $d->content }}</div>
            </div>
        @endforeach
        <div class="row mt-2"><div class="mx-auto">{{ $repliedReported->appends(request()->except('page'))->links() }}</div></div>
    @endif
@endsection