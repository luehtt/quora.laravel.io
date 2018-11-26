@extends('layouts.user')

@section('content')

    {{--navigator section--}}
    <div class="card mb-4">
        <div class="card-header bg-success border-success">
            <div><a href="{{ url('/channel') }}">Tất cả đề mục</a></div>
            <div>
                @foreach($items as $d)
                    <a class="mr-2" href="{{ url('/channel/'.$d->slug) }}">{{ $d->name }}</a>
                @endforeach
            </div>
        </div>
    </div>

    {{--discussions section--}}
    @if(isset($items))
        @foreach($items as $t)
            <div class="card mb-4">
                <div class="card-header"><span class="text-uppercase">{{ $t->name }}</span>
                    <p class="mb-0 float-md-right"><a href="{{ url('/channel/'.$t->slug) }}">Tất cả</a></p>
                </div>

                <div class="card-body text-justify">
                    @foreach($t->topics as $d)
                        <div class="row">
                            <div class="col-12 col-sm-3"><a href="{{ url('/channel/topic/'.$d->slug) }}">{{ $d->name }}</a></div>
                            <div class="col-12 col-sm-9 text-truncate">{{ $d->description }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
@endsection