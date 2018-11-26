@include('include.header')

<body class="bg-light">
@include('include.navbar')

<div class="container">
    <div class="row pt-4">
        <div class="col-12">@include('include.message')</div>

        @auth
        <div class="col-md-3 mb-4">
            <div class="card mb-4">
                <ul class="list-group list-group-flush text-left">
                    <li class="list-group-item"><a href={{ url('/home') }}>
                            <div class="row">
                                <div class="col-2 text-center"><i class="fas fa-home"></i></div>
                                <div class="col-10">Trang chính</div>
                            </div>
                        </a></li>
                    <li class="list-group-item"><a href={{ url('/top') }}>
                            <div class="row">
                                <div class="col-2 text-center"><i class="fas fa-fire"></i></div>
                                <div class="col-10">Nổi bật</div>
                            </div>
                        </a></li>
                    <li class="list-group-item"><a href={{ url('/bookmark') }}>
                            <div class="row">
                                <div class="col-2 text-center"><i class="fas fa-bookmark"></i></div>
                                <div class="col-10">Theo dõi</div>
                            </div>
                        </a></li>
                    <li class="list-group-item"><a href={{ url('/channel') }}>
                            <div class="row">
                                <div class="col-2 text-center"><i class="fas fa-book"></i></div>
                                <div class="col-10">Tất cả</div>
                            </div>
                        </a></li>
                    <li class="list-group-item"><a href={{ url('/search') }}>
                            <div class="row">
                                <div class="col-2 text-center"><i class="fas fa-search"></i></div>
                                <div class="col-10">Tìm kiếm</div>
                            </div>
                        </a></li>
                </ul>
            </div>

            @if (count($topic_bookmarks) != 0 )
            <div class="card mb-4">
                <div class="card-header">Chủ đề theo dõi</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($topic_bookmarks as $t)
                            <li class="list-group-item border-0 px-2 py-1"><a href={{ url('/channel/topic/'.$t->slug) }}>{{ $t->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
        @endauth

        @guest
            <div class="col-md-3 mb-4">
                <div class="card mb-4">
                    <ul class="list-group list-group-flush text-left">
                        <li class="list-group-item"><a href={{ url('/home') }}>
                                <div class="row">
                                    <div class="col-2 text-center"><i class="fas fa-home"></i></div>
                                    <div class="col-10">Trang chính</div>
                                </div>
                            </a></li>
                        <li class="list-group-item"><a href={{ url('/channel') }}>
                                <div class="row">
                                    <div class="col-2 text-center"><i class="fas fa-book"></i></div>
                                    <div class="col-10">Tất cả</div>
                                </div>
                            </a></li>
                        <li class="list-group-item"><a href={{ url('/search') }}>
                                <div class="row">
                                    <div class="col-2 text-center"><i class="fas fa-search"></i></div>
                                    <div class="col-10">Tìm kiếm</div>
                                </div>
                            </a></li>
                        <li class="list-group-item"><a href={{ url('/login') }}>
                                <div class="row">
                                    <div class="col-2 text-center"><i class="fas fa-sign-in-alt"></i></div>
                                    <div class="col-10">Đăng nhập</div>
                                </div>
                            </a></li>
                        <li class="list-group-item"><a href={{ url('/register') }}>
                                <div class="row">
                                    <div class="col-2 text-center"><i class="fas fa-key"></i></div>
                                    <div class="col-10">Đăng kí</div>
                                </div>
                            </a></li>
                    </ul>
                </div>
            </div>
        @endguest

        <div class="col-md-9 mb-4">
            @yield('content')
        </div>
    </div>
</div>
</body>

</html>