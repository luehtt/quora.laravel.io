@if(count($errors) > 0)
    @foreach($errors->all() as $e)
        <div class="alert alert-danger py-2 mt-4 mb-2">
            {{$e}}
        </div>
    @endforeach
@endif

@if(session('success') == true && session('message') != null)
    <div class="alert alert-success py-2 mt-4 mb-2">
        {{session('message')}}
    </div>
@endif

@if(session('success') == false && session('message') != null)
    <div class="alert alert-danger py-2 mt-4 mb-2">
        {{session('message')}}
    </div>
@endif