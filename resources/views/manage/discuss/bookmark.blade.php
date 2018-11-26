@extends('layouts.admin')

@section('content')

    {{--discussions section--}}
    @if(isset($items))
        @foreach($items as $d)
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2 d-md-table d-none text-center">
                            @if(isset($d->user->photo) && $d->user->photo != '')
                                <img class="img-fluid rounded-circle" style="width: 100%; max-width: 70px; max-height: 70px"
                                     src="{{ url('storage/img/user/'.$d->user->photo)}}" alt="{{$d->user->photo}}">
                            @endif
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="mb-2"><a class="h3" href="{{ url('/discussion/'.$d->slug) }}">{{ $d->title }}</a>
                            <p class="mb-0"><a href="{{ url('/manage/user'.$d->user->id) }}">{{ $d->user->name }}</a> trong mục
                                <a href="{{ url('/channel/topic/'.$d->topic->id) }}">{{ $d->topic->name }}</a>
                                lúc {{ $d->created_at }} đạt {{ $d->views }} lượt xem.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body img-hidden text-justify">{!! $d->content !!}</div>
            </div>
        @endforeach
        <div class="row mt-2"><div class="mx-auto">{{ $items->links() }}</div></div>
    @endif
@endsection