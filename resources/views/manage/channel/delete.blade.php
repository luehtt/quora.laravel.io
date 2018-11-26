@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Xóa đề mục</div>
        <div class="card-body">
            {!! Form::open(['route' => ['channel.destroy', $item->id], 'method' => 'DELETE']) !!}
            <p class="text-center">Bạn thật sự muốn xóa <span class="text-danger">{{ $item->name }}</span>!</p>
            <div class="text-center">
                <a href="{{ url('/manage/channel') }}" class="btn btn-mdb-color">Trở lại</a>
                <button type="submit" class="btn btn-danger">Thực thi</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection