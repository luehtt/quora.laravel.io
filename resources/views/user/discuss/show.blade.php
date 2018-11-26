
@extends('layouts.user')

@section('content')

    {{--reply model--}}
    <div id="reply-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="main">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gửi phản hồi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => ['user.discussion.reply', $item->id], 'method' => 'POST']) !!}
                <div class="modal-body">
                    <div class="form-group row">
                        {{ Form::label('content', 'Nội dung', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                        <div class="col-md-9">
                            {!! Form::textarea('content', null, ['id' => 'ckeditor', 'class'=>'form-control', 'rows' => 5, 'maxlength' => 2048]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-info">Thực hiện</button>
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
                @if (isset($topic))
                    <i class="fas fa-chevron-right ml-3 mr-2"></i>
                    <a href="{{ url('/channel/topic/'.$topic->slug) }}">{{ $topic->name }}</a>
                @endif
            </div>
        </div>
    </div>

    {{--discussion section--}}
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-2 d-sm-table d-none text-center">
                    @if(isset($item->user->photo) && $item->user->photo != '')
                        <img class="img-fluid rounded-circle w-100" style="max-width: 100px; max-height: 100px"
                             src="{{ url('storage/img/user/'.$item->user->photo)}}" alt="{{$item->user->photo}}">
                    @endif
                </div>
                <div class="col-sm-10 col-12 my-auto">
                    <p class="mb-2"><a class="h3" href="{{ url('/discussion/'.$item->slug) }}">{{ $item->title }}</a></p>
                    <p class="mb-2">{{ $item->user->name }}
                        trong mục <a href="{{ url('/topic/'.$item->topic->id) }}">{{ $item->topic->name }}</a>
                        lúc {{ $item->created_at }} đạt {{ $item->views }} lượt xem</p>
                    <div class="mb-0 form-inline">
                        {{--if user has manageable rights--}}
                        @if ($item->manageable)
                            @if ($item->archived == true)
                                <button class="btn btn-success py-1 px-3 mr-1 mb-1 ml-0" type="button">Đã lưu</button>
                            @else
                                <a class="btn btn-success py-1 px-3 mr-1 mb-1 ml-0" href="{{ url('/discussion/'.$item->slug.'/archive')}}">Lưu</a>
                            @endif
                                <a class="btn btn-danger py-1 px-3 mr-1 mb-1" href="{{ url('/discussion/'.$item->slug.'/delete')}}">Xóa</a>
                            @if(!$item->bookmarkable)
                                <a class="btn btn-secondary py-1 px-3 mb-1" href="{{ url('discussion/'.$item->slug.'/report') }}">
                                    <i class="fas fa-bug"></i><span class="ml-2">{{ count($item->reports) }}</span></a>
                            @endif
                        @endif
                        {{--if user has none manageable rights--}}
                        @if ($item->bookmarkable)
                            @if ($item->archived == true)
                                <button class="btn btn-success py-1 mr-1 mb-1" type="button">Đã lưu</button>
                            @endif
                            @if ($item->bookmarked)
                                {!! Form::open(['route' => ['user.discussion.bookmark', $item->id], 'method' => 'POST']) !!}
                                    <button class="btn btn-deep-orange py-1 px-3 mr-1 mb-1">Đang theo dõi</button>
                                {!! Form::close() !!}
                            @else
                                {!! Form::open(['route' => ['user.discussion.bookmark', $item->id], 'method' => 'POST']) !!}
                                    <button class="btn btn-orange py-1 px-3 mr-1 mb-1">Theo dõi</button>
                                {!! Form::close() !!}
                            @endif
                            @if ($item->reported)
                                <a class="btn btn-danger py-1 px-3 mr-1 mb-1" href="{{ url('discussion/'.$item->slug.'/report') }}">
                                    <i class="fas fa-bug"></i><span class="ml-2">{{ count($item->reports) }}</span></a>
                            @else
                                <a class="btn btn-mdb-color py-1 px-3 mr-1 mb-1" href="{{ url('discussion/'.$item->slug.'/report') }}">
                                    <i class="fas fa-bug"></i><span class="ml-2">{{ count($item->reports) }}</span></a>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body text-justify">{!! $item->content !!}</div>
    </div>

    {{--add new reply--}}
    <div class="mb-4">
        @if ($item->archived == true)
            <button type="button" class="btn btn-lg btn-primary ml-0" disabled>Phản hồi<i class="fas fa-reply ml-2"></i></button>
        @else
            <button type="button" class="btn btn-lg btn-primary ml-0" data-toggle="modal" data-target="#reply-modal">Phản hồi<i class="fas fa-reply ml-2"></i></button>
        @endif
        <a class="btn btn-lg btn-mdb-color float-right ml-0 mr-0" href="{{ url('/channel/topic/'.$topic->slug) }}">
            <i class="fas fa-arrow-left mr-2"></i>Trở lại</a>
    </div>

    {{--replies section--}}
    @if(isset($replies))
        @foreach($replies as $d)
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-2 d-sm-table d-none text-center">
                            @if(isset($d->user->photo) && $d->user->photo != '')
                                <img class="img-fluid rounded-circle w-100" style="max-width: 80px; max-height: 80px"
                                     src="{{ url('storage/img/user/'.$d->user->photo)}}" alt="{{$d->user->photo}}">
                            @endif
                        </div>

                        <div class="col-sm-10 col-12 my-auto">
                            <p class="mb-2">{{ $d->user->name }} phản hồi lúc {{ $d->created_at }}</p>
                            <div class="mb-0 form-inline">
                                {{--form upvote--}}
                                @if ($d->user_id == $user->id)
                                    <button type="button" class="btn btn-success py-1 px-3 mr-1 mb-1" disabled><i class="fas fa-thumbs-up"></i>
                                        <span class="ml-1">{{ count($d->upvotes) }}</span></button>
                                @else
                                    {!! Form::open(['route' => ['user.reply.upvote', $d->id], 'method' => 'POST']) !!}
                                    @if ($d->upvoted)
                                        <button class="btn btn-success py-1 px-3 mr-1 mb-1"><i class="fas fa-thumbs-up"></i>
                                            <span class="ml-1">{{ count($d->upvotes) }}</span></button>
                                    @else
                                        <button class="btn btn-mdb-color py-1 px-3 mr-1 mb-1"><i class="fas fa-thumbs-up"></i>
                                            <span class="ml-1">{{ count($d->upvotes) }}</span></button>
                                    @endif
                                    {!! Form::close() !!}
                                @endif

                                {{--form downvote--}}
                                @if ($d->user_id == $user->id)
                                    <button type="button" class="btn btn-warning py-1 px-3 mr-1 mb-1" disabled><i class="fas fa-thumbs-down"></i>
                                        <span class="ml-1">{{ count($d->downvotes) }}</span></button>
                                @else
                                    {!! Form::open(['route' => ['user.reply.downvote', $d->id], 'method' => 'POST']) !!}
                                    @if ($d->downvoted)
                                        <button class="btn btn-warning py-1 px-3 mr-1 mb-1"><i class="fas fa-thumbs-down"></i>
                                            <span class="ml-1">{{ count($d->downvotes) }}</span></button>
                                    @else
                                        <button class="btn btn-mdb-color py-1 px-3 mr-1 mb-1"><i class="fas fa-thumbs-down"></i>
                                            <span class="ml-1">{{ count($d->downvotes) }}</span></button>
                                    @endif
                                    {!! Form::close() !!}
                                @endif

                                {{--form report--}}
                                @if ($d->reported)
                                    <a class="btn btn-danger py-1 px-3 mr-1 mb-1" href="{{ url('/reply/'.$d->id.'/report') }}">
                                        <i class="fas fa-bug"></i><span class="ml-2">{{ count($d->reports) }}</span></a>
                                @else
                                    <a class="btn btn-mdb-color py-1 px-3 mr-1 mb-1" href="{{ url('/reply/'.$d->id.'/report') }}">
                                        <i class="fas fa-bug"></i><span class="ml-2">{{ count($d->reports) }}</span></a>
                                @endif

                                {{--form delete--}}
                                @if ($d->deleteable)
                                    <a class="btn btn-danger py-1 px-3 mr-1 mb-1" href="{{ url('/reply/'.$d->id.'/delete') }}">Xóa</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body text-justify">{!! $d->content !!}</div>
            </div>
        @endforeach
        <div class="row mt-3"><div class="mx-auto">{{ $replies->links() }}</div></div>
    @endif


    <script>
        ClassicEditor
            .create(document.querySelector('#ckeditor'), {
                toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection