@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Danh sách thành viên</div>
        <div class="card-body">
            @if(count($items) > 0)
                @foreach($items as $t)

                <div class="row no-gutters align-items-center pb-2">
                        <div class="col-4"><a href="{{ url('manage/user/'.$t->id) }}">
                                @if(!$t->enabled)<span class="text-danger">{{ $t->name }}</span>
                                @else {{ $t->name }}
                                @endif
                            </a></div>
                        <div class="col-4 text-right">{{ $t->email }}</div>
                        <div class="col-4 text-right">{{ $t->created_at }}</div>
                </div>
                @endforeach

                <div class="row mt-2"><div class="mx-auto">{{ $items->links() }}</div></div>
            @endif
        </div>
    </div>
@endsection