
@extends('layouts.user')

@section('content')
    {{--discussion section--}}
    {!! Form::open(['route' => ['user.home.search'], 'method' => 'GET']) !!}
    <div class="form-group row">
        <div class="col-9">
            <input name="search" value="{{ $search }}" class="form-control" placeholder="nhập tìm kiếm từ khóa tìm kiếm">
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-info w-100 py-2 m-0">Tìm kiếm</button>
        </div>
    </div>
    {!! Form::close() !!}

    {{--discussions section--}}
    @if(isset($items))
        @if(count($items) != 0)
            @foreach($items as $d)
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2 d-md-table d-none text-center">
                                @if(isset($d->user->photo) && $d->user->photo != '')
                                    <img class="img-fluid rounded-circle" style="width: 100%; max-width: 80px; max-height: 80px" src="{{ url('storage/img/user/'.$d->user->photo)}}" alt="{{$d->user->photo}}">
                                @endif
                            </div>
                            <div class="col-md-10 col-12">
                                <p class="mb-2"><a class="h3" href="{{ url('/discussion/'.$d->slug) }}">{{ $d->title }}</a>
                                <p class="mb-0">{{ $d->user->name }} trong mục <a href="{{ url('/channel/topic/'.$d->topic->id) }}">{{ $d->topic->name }}</a> lúc {{ $d->created_at }} đạt {{ $d->views }} lượt xem.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body img-hidden text-justify">{!! $d->content !!}</div>
                </div>
            @endforeach
            <div class="row mt-2"><div class="mx-auto">{{ $items->appends(request()->except('page'))->links() }}</div></div>
        @else
            @if(isset($search))
                <div class="row mt-2"><div class="col-12">Không tìm được thảo luận nào</div></div>
            @endif
        @endif
    @endif
@endsection