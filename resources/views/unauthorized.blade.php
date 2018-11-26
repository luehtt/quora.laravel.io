<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="css/app.css" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            .full-height {
                height: 80vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 100px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>

    <body class="bg-light">

    @include('include.navbar')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">Unauthorized</div>
            <div class="m-b-md">Bạn không có quyền truy cập</div>
            <div class="links">
                <a href="{{ url('/home') }}">Trang chính</a>
                <a href="{{ route('login') }}">Đăng nhập</a>
                <a href="{{ route('register') }}">Đăng kí</a>
                <a href="{{ route('password.request') }}">Quên mật khẩu</a>
            </div>
        </div>
    </div>
    </body>
</html>
