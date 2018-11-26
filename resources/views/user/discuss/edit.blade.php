@extends('layouts.admin')

@section('content')
    {{--navigator section--}}
    <div class="card mb-4">
        <div class="card-header bg-success border-success">
            <div>
                <a href="{{ url('/channel') }}">Tất cả đề mục</a>
                <i class="fas fa-chevron-right ml-3 mr-2"></i>
                <a href="{{ url('/channel/'.$item->topic->channel->slug) }}">{{ $item->topic->channel->name }}</a>
                @if (isset($item->topic))
                    <i class="fas fa-chevron-right ml-3 mr-2"></i>
                    <a href="{{ url('/channel/topic/'.$item->topic->slug) }}">{{ $item->topic->name }}</a>
                    <i class="fas fa-chevron-right ml-3 mr-2"></i>
                    <a href="{{ url('/discussion/'.$item->slug) }}">Trở lại</a>
                @endif
            </div>
        </div>
    </div>

    {{--update section--}}
    <div class="card">
        <div class="card-header">Cập nhật thảo luận</div>
        <div class="card-body">
            {!! Form::open(['route' => ['user.discussion.update', $item->id], 'method' => 'PUT']) !!}
            <div class="form-group row">
                {{ Form::label('title', 'Tiêu đề', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {!! Form::textarea('title', $item->title, ['class'=>'form-control', 'rows' => 2, 'maxlength' => 128]) !!}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('group', 'Chủ đề', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {{ Form::select('topic_id', $topics->pluck('name', 'id'), $item->topic_id, ['required', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('content', 'Nội dung', ['class' => 'col-md-3 col-form-label text-md-right']) }}
                <div class="col-md-9">
                    {!! Form::textarea('content', $item->content, ['id' => 'ckeditor', 'class'=>'form-control', 'rows' => 6, 'maxlength' => 2048]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3"></label>
                <div class="col-md-9">
                    <a href="{{ url('/discussion/'.$item->slug) }}" class="btn btn-mdb-color ml-0">Trở lại</a>
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