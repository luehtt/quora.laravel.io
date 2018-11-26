@extends('layouts.user')

@section('content')

    {{--navigator section--}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Ảnh đại diện</div>
                <div class="card-body">
                    @if(isset($item->photo) && $item->photo != '')
                        <img class="img-fluid rounded-circle" style="width: 100%"
                             src="{{ url('storage/img/user/'.$item->photo)}}" alt="{{$item->photo}}">
                    @endif
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'user.account.photo', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                        {{ Form::file('photo', ['class' => 'form-control pb-5']) }}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mx-auto">Cập nhật</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Thông tin tài khoản</div>
                <div class="card-body">
                    <div class="row mb-1">
                        <div class="col-sm-5">Tên</div>
                        <div class="col-sm-7">{{ $item->name }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Tài khoản</div>
                        <div class="col-sm-7">{{ $item->user_role->name }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Địa chỉ Email</div>
                        <div class="col-sm-7">{{ $item->email }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Tham gia</div>
                        <div class="col-sm-7">{{ $item->created_at }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Cập nhật gần nhất</div>
                        <div class="col-sm-7">{{ $item->updated_at }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Gửi thảo luận</div>
                        <div class="col-sm-7">{{ $item->discussions_count }} lượt</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Gửi phản hồi</div>
                        <div class="col-sm-7">{{ $item->replies_count }} lượt</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Tố cáo thảo luận</div>
                        <div class="col-sm-7">{{ $item->discussion_reports_count }} lượt</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Tố cáo phản hồi</div>
                        <div class="col-sm-7">{{ $item->reply_reports_count }} lượt</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Tán thành</div>
                        <div class="col-sm-7">{{ $item->reply_upvotes_count }} lượt</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5">Không tán thành</div>
                        <div class="col-sm-7">{{ $item->reply_downvotes_count }} lượt</div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Thay đổi mật khẩu</div>
                <div class="card-body">
                    {!! Form::open(['route' => 'user.account.password', 'method' => 'POST']) !!}
                    <div class="form-group row">
                        {{ Form::label('require-password', 'Mật khẩu đang dùng', ['class' => 'col-md-5 col-form-label']) }}
                        <div class="col-md-7">
                            <input id="require-password" name="require-password" type="password" class="form-control" maxlength="128" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('password', 'Mật khẩu mới', ['class' => 'col-md-5 col-form-label']) }}
                        <div class="col-md-7">
                            <input id="password" name="password" type="password" class="form-control" maxlength="128" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('confirm-password', 'Nhập lại mật khẩu', ['class' => 'col-md-5 col-form-label']) }}
                        <div class="col-md-7">
                            <input id="confirm-password" name="confirm-password" type="password" class="form-control" maxlength="128" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="text-center"><button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button></div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


