@extends('layouts.admin')

@section('content')
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
                    <i class="fas fa-chevron-right ml-3 mr-2"></i>
                    <a href="{{ url('/channel/topic/'.$topic->slug) }}">Trở lại</a>
                @endif
            </div>
        </div>
    </div>

    {{--add new section--}}
    <div class="card">
        <div class="card-header">Thảo luận mới</div>
        <div class="card-body">
            {!! Form::open(['route' => 'user.discussion.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group row">
                {{ Form::label('title', 'Tiêu đề', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {!! Form::textarea('title', null, ['class'=>'form-control', 'rows' => 2, 'maxlength' => 128]) !!}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('group', 'Chủ đề', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {{ Form::select('topic_id', $topics->pluck('name', 'id'), null, ['required', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('content', 'Nội dung', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {!! Form::textarea('content', null, ['id' => 'ckeditor', 'class'=>'form-control', 'rows' => 6, 'maxlength' => 2048]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3"></label>
                <div class="col-md-9">
                    <a href="{{ url('/channel/topic/'.$topic->slug) }}" class="btn btn-mdb-color ml-0">Trở lại</a>
                    <button type="submit" class="btn btn-primary mr-0">Thực thi</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

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