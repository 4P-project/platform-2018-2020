<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@yield("title") | 4THPILLAR </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="{{url('img/4thpillar/favicon.ico')}}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- global css -->
    <link type="text/css" href="{{asset('css/app.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
    <!-- end of global css -->
    @yield('header_styles')
</head>

<body class="skin-default">
<div class="preloader">
    <div class="loader_img">
        <img src="{{asset('img/loader.gif')}}" alt="loading..." height="64" width="64">
    </div>
</div>
<!-- header logo: style can be found in header-->
<header class="header">
    @include('account.layouts.header')
</header>

<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar-->
        <section class="sidebar">
            <div id="menu" role="navigation">
                @include('account.layouts.leftmenu')
            </div>
            <!-- menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <aside class="right-side">
        <!-- Warning -->
        <div class="col-sm-12" style="background: #eeee22; padding: 10px; margin: 0 0 7px 0;">
            THIS IS JUST A PRELIMINARY (BETA) VERSION OF THE PLATFORM. TOKENS USED IN THIS VERSION OF THE PLATFORM ARE ONLY TEST VERSION OF FOUR TOKENS AND THEY ARE FUNCTIONING ON KOVAN TESTNET NETWORK ONLY AND HAVE NO ACTUAL MARKET WORTH.
        </div>
        @yield('page-header')
        <!-- Main content -->
        <section class="content">
            @yield("content")
        </section>
        <!-- /.content -->
    </aside>
    <!-- /.right-side -->
</div>

<!-- /.right-side -->
<!-- ./wrapper -->
<!-- global js -->
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
<!-- end of page level js -->
@yield('footer_scripts')

@include('account.layouts.notifications')

</body>
</html>
