@extends('layouts.user')

@section('content')
    <div class="card">
        <div class="card-header">Xóa phản hồi</div>
        <div class="card-body">
            {!! Form::open(['route' => ['user.reply.destroy', $item->id], 'method' => 'DELETE']) !!}
            <p class="text-center">Bạn thật sự muốn xóa phản hồi</p>
            <p class="text-center">Tất cả lượt tán thưởng của các thành viên sẽ bị xóa!!!</p>

            <div class="text-center">
                <a href="{{ url('/discussion/'.$discussion->slug) }}" class="btn btn-mdb-color ml-0">Trở lại</a>
                <button type="submit" class="btn btn-danger mr-0">Thực thi</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection