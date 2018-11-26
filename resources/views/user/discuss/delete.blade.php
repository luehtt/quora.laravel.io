@extends('layouts.user')

@section('content')
    <div class="card">
        <div class="card-header">Xóa thảo luận</div>
        <div class="card-body">
            {!! Form::open(['route' => ['user.discussion.destroy', $item->id], 'method' => 'DELETE']) !!}
            <p class="text-center">Bạn thật sự muốn xóa <span class="text-danger">{{ $item->title }}</span>!</p>
            <p class="text-center">Tất cả phản hồi, theo dõi của các thành viên sẽ bị xóa!!!</p>
            <div class="text-center">
                <a href="{{ url('/discussion/'.$item->slug) }}" class="btn btn-mdb-color ml-0">Trở lại</a>
                <button type="submit" class="btn btn-danger mr-0">Thực thi</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection