<!DOCTYPE html>
<html>
<head>
    <title>404 error| Clear Admin Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico"/>
    <!-- global level css -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <!-- end of global css-->
    <!-- page level styles-->
    <link href="{{asset('css/404.css')}}" rel="stylesheet">
    <!-- end of page level styles-->
    <style>

    </style>
</head>

<body>
<div class="preloader">
    <div class="loader_img ml-auto">
        <img src="{{asset('img/loader.gif')}}" alt="loading..." height="64" width="64">
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-8 mx-auto">
            <div class="text-center">
                <div class="error_img">
                    <img src="{{asset('img/pages/404.gif')}}" alt="404 error image">
                </div>
                <hr class="seperator">
                <a href="{{url('/account')}}" class="btn btn-primary link-home">Go Home</a>
            </div>
        </div>
    </div>
</div>
<!-- global js -->
<script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap.js')}}" type="text/javascript"></script>
<!-- end of global js -->
<script type="text/javascript">
    //=================Preloader===========//
    $(window).on('load', function() {
        $('.preloader img').fadeOut();
        $('.preloader').fadeOut();
    });
    //=================end of Preloader===========//
</script>
</body>

</html>

