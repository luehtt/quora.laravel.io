@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Danh sách đề mục
            <p class="mb-0 float-md-right"><a href="{{ url('/manage/channel/create')}}">Thêm đề mục</a></p>
        </div>
        <div class="card-body">
            @if(count($items) > 0)
                @foreach($items as $t)
                <div class="row no-gutters align-items-center pb-2">
                        <div class="col-4"><a href="{{ url('manage/channel/'.$t->id) }}">{{ $t->name }}</a></div>
                        <div class="col-4 text-right">{{ count($t->topics) }} chủ đề</div>
                        <div class="col-4 text-right">
                            <a class="border-0 text-info py-0 px-1"
                               href="{{ url('/manage/channel/'.$t->id.'/edit')}}"><i class="fas fa-edit"></i></a>
                            <a class="border-0 text-danger py-0 px-1"
                               href="{{ url('/manage/channel/'.$t->id.'/delete')}}"><i class="fas fa-trash-alt"></i></a>
                        </div>
                </div>
                @endforeach
                <div class="row mt-2"><div class="mx-auto">{{ $items->links() }}</div></div>
            @endif
        </div>
    </div>
@endsection