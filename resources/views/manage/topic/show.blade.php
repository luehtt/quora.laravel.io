@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">{{ $topic->name }}
            <p class="mb-0 float-md-right">
                <a class="mr-3" href="{{ url('manage/channel/'.$topic->channel_id) }}">Trở lại</a>
            </p>
        </div>
        <div class="card-body">
            @if(count($items) > 0)
                @foreach($items as $t)
                <div class="row no-gutters align-items-center pb-2">
                        <div class="col-3"><a href="{{ url('/manage/user/'.$t->user_id) }}">{{ $t->user->name }}</a></div>
                        <div class="col-6"><a href="{{ url('/discussion/'.$t->slug) }}">{{ $t->title }}</a></div>
                        <div class="col-3 text-right">
                            <a class="border-0 text-info py-0 px-1"
                               href="{{ url('/manage/discussion/'.$t->id.'/bookmark')}}"><i class="fas fa-bookmark"></i></a>
                            <a class="border-0 text-danger py-0 px-1"
                               href="{{ url('/manage/discussion/'.$t->id.'/delete')}}"><i class="fas fa-trash-alt"></i></a>
                        </div>
                </div>
                @endforeach
                <div class="row mt-2"><div class="mx-auto">{{ $items->links() }}</div></div>
            @endif
        </div>
    </div>
@endsection