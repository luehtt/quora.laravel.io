@extends('layouts.user')

@section('content')

    {{--navigator section--}}
    <div class="card mb-4">
        <div class="card-header bg-success border-success">
            <div><a class="mr-2" href="?view=bookmarked">Theo dõi</a>
            <a class="mr-2" href="?view=posted">Thảo luận</a>
            <a class="mr-2" href="?view=replied">Trả lời</a>
            <a class="mr-2" href="?view=reported">Tố cáo</a></div>
        </div>
    </div>

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
        <div class="row mt-3"><div class="mx-auto">{{ $items->appends(request()->except('page'))->links() }}</div></div>
    @endif
@endsection