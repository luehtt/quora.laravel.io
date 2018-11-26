@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Thêm chủ đề</div>
        <div class="card-body">
            {!! Form::open(['route' => 'topic.store', 'method' => 'POST']) !!}
            <div class="form-group row">
                {{ Form::label('name', 'Tên', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {{ Form::text('name', null, ['maxlength' => 128, 'required', 'class' => 'form-control'] ) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('group', 'Đề mục', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {{ Form::select('channel_id', $groups->pluck('name', 'id'), $channel, ['required', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('description', 'Mô tả', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {!! Form::textarea('description', null, ['class'=>'form-control', 'rows' => 4, 'maxlength' => 2048]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3"></label>
                <div class="col-md-9">
                    @if (isset($channel))
                        <a href="{{ url('/manage/channel/'.$channel->id) }}" class="btn btn-mdb-color ml-0">Trở lại</a>
                    @else
                        <a href="{{ url('/manage/topic') }}" class="btn btn-mdb-color ml-0">Trở lại</a>
                    @endif
                        <button type="submit" class="btn btn-info mr-0">Thực thi</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection