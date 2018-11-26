@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Thêm đề mục</div>
        <div class="card-body">
            {!! Form::open(['route' => 'channel.store', 'method' => 'POST']) !!}
            <div class="form-group row">
                {{ Form::label('name', 'Tên', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {{ Form::text('name', null, ['maxlength' => 128, 'required', 'class' => 'form-control'] ) }}
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
                    <a href="{{ url('/manage/channel') }}" class="btn btn-mdb-color ml-0">Trở lại</a>
                    <button type="submit" class="btn btn-primary mr-0">Thực thi</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection