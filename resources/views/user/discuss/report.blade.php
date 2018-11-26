@extends('layouts.user')

@section('content')

    {{--report model--}}
    <div id="report-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="main">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gửi tố cáo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => ['user.discussion.report', $item->id], 'method' => 'POST']) !!}
                <div class="modal-body">
                    <div class="form-group row">
                        {{ Form::label('report_reason_id', 'Lí do', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                        <div class="col-md-9">
                            {{ Form::select('report_reason_id', $reasons->pluck('name', 'id'), null, ['required', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('content', 'Nội dung', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                        <div class="col-md-9">
                            {!! Form::textarea('content', null, ['class'=>'form-control', 'rows' => 5, 'maxlength' => 2048]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-mdb-color" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Thực hiện</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{--navigator section--}}
    <div class="card mb-4">
        <div class="card-header bg-success border-success">
            <div>
                <a href="{{ url('/channel') }}">Tất cả đề mục</a>
                <i class="fas fa-chevron-right ml-3 mr-2"></i>
                <a href="{{ url('/channel/'.$channel->slug) }}">{{ $channel->name }}</a>
                <i class="fas fa-chevron-right ml-3 mr-2"></i>
                <a href="{{ url('/channel/topic/'.$topic->slug) }}">{{ $topic->name }}</a>
                <i class="fas fa-chevron-right ml-3 mr-2"></i>
                <a href="{{ url('/discussion/'.$item->slug) }}">Trở lại</a>
            </div>
        </div>
    </div>

    {{--discussion section--}}
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-2 d-sm-table d-none text-center">
                    @if(isset($item->user->photo) && $item->user->photo != '')
                        <img class="img-fluid rounded-circle w-100" style="max-width: 80px; max-height: 80px"
                             src="{{ url('storage/img/user/'.$item->user->photo)}}" alt="{{$item->user->photo}}">
                    @endif
                </div>
                <div class="col-sm-10 col-12 my-auto">
                    <p class="mb-2"><a class="h3" href="{{ url('/discussion/'.$item->slug) }}">{{ $item->title }}</a></p>
                    <p class="mb-2">{{ $item->user->name }}
                        trong mục <a href="{{ url('/topic/'.$item->topic->id) }}">{{ $item->topic->name }}</a>
                        lúc {{ $item->created_at }} đạt {{ $item->view }} lượt xem</p>
                </div>
            </div>
        </div>
        <div class="card-body text-justify">{!! $item->content !!}</div>
    </div>

    {{--add new report--}}
    <div class="mb-4">
        @if ($item->reportable)
            <button type="button" disabled class="btn btn-lg btn-danger ml-0">
                Gửi tố cáo<i class="fas fa-exclamation-triangle ml-2"></i></button>
        @else
            <button type="button" class="btn btn-lg btn-danger ml-0" data-toggle="modal" data-target="#report-modal">
                Gửi tố cáo<i class="fas fa-exclamation-triangle ml-2"></i></button>
        @endif

        <a class="btn btn-lg btn-mdb-color mr-0 float-right" href="{{ url('/discussion/'.$item->slug) }}">
            <i class="fas fa-arrow-left mr-2"></i>Trở lại</a>
    </div>

    {{--reports section--}}
    @if(isset($reports))
        @foreach($reports as $d)
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
                            <p class="mb-2">{{ $d->user->name }} tố cáo lúc {{ $d->created_at }}</p>
                            <p>Lí do: {{ $d->reason->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body text-justify">{{ $d->content }}</div>
            </div>
        @endforeach
    @endif

@endsection

