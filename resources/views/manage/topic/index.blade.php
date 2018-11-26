@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header"><div>Danh sách chủ đề</div>
            @foreach($channels as $d)
                <a class="mr-2" href="{{ url('/manage/channel/'.$d->id) }}">{{ $d->name }}</a>
            @endforeach
        </div>
        <div class="card-body">
            @if(count($items) > 0)
                @foreach($items as $t)
                <div class="row no-gutters align-items-center pb-2">
                        <div class="col-6"><a href="{{ url('manage/topic/'.$t->id) }}">{{ $t->name }}</a></div>
                        <div class="col-3"><a href="{{ url('manage/channel/'.$t->channel->id) }}">{{ $t->channel->name }}</a></div>
                        <div class="col-3 text-right">
                            <a class="border-0 text-info py-0 px-1"
                               href="{{ url('/manage/topic/'.$t->id.'/edit')}}"><i class="fas fa-edit"></i></a>
                            <a class="border-0 text-danger py-0 px-1"
                               href="{{ url('/manage/topic/'.$t->id.'/delete')}}"><i class="fas fa-trash-alt"></i></a>
                        </div>
                </div>
                @endforeach

                <div class="row mt-2"><div class="mx-auto">{{ $items->links() }}</div></div>
            @endif
        </div>
    </div>
@endsection