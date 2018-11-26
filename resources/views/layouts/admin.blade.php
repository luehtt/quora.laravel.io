@include('include.header')

<body class="bg-light">
@include('include.navbar')

<div class="container">
    <div class="row pt-4">
        <div class="col-12">@include('include.message')</div>

        <div class="col-md-3 mb-4">
            <div class="card mb-4">
                <ul class="list-group list-group-flush text-left">
                    <li class="list-group-item"><a href={{ url('/manage/channel') }}>
                            <div class="row">
                                <div class="col-2 text-center"><i class="fas fa-database"></i></div>
                                <div class="col-10">Đề mục</div>
                            </div>
                        </a></li>
                    <li class="list-group-item"><a href={{ url('/manage/topic') }}>
                            <div class="row">
                                <div class="col-2 text-center"><i class="fas fa-book"></i></div>
                                <div class="col-10">Chủ đề</div>
                            </div>
                        </a></li>
                    <li class="list-group-item"><a href={{ url('/manage/user') }}>
                            <div class="row">
                                <div class="col-2 text-center"><i class="fas fa-user"></i></div>
                                <div class="col-10">Thành viên</div>
                            </div>
                        </a></li>
                    <li class="list-group-item"><a href={{ url('/manage/discussion/bookmark') }}>
                            <div class="row">
                                <div class="col-2 text-center"><i class="fas fa-bookmark"></i></div>
                                <div class="col-10">Theo dõi</div>
                            </div>
                        </a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-9 mb-4">
            @yield('content')
        </div>
    </div>
</div>
</body>

</html>