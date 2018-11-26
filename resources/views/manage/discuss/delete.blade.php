@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Xóa thảo luận</div>
        <div class="card-body">
            {!! Form::open(['route' => ['discussion.destroy', $item->id], 'method' => 'DELETE']) !!}
            <p class="text-center">Bạn thật sự muốn xóa <span class="text-danger">{{ $item->title }}</span>!</p>
            <div class="text-center">
                <a href="{{ url('/manage/topic/'.$item->topic_id) }}" class="btn btn-secondary">Trở lại</a>
                <button type="submit" class="btn btn-danger">Thực thi</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection