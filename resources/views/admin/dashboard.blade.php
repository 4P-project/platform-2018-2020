@extends('admin.layouts.master')
{{-- Page title --}}
@section('title', 'Dashboard')
{{-- local styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('vendors/nvd3/css/nv.d3.min.css') }}" rel="stylesheet" type="text/css">
    <!--weathericons-->
    <link href="{{ asset('vendors/weathericon/css/weather-icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('vendors/metrojs/css/MetroJs.min.css') }}">
    <link href="{{ asset('css/custom_css/dashboard2.css') }}" rel="stylesheet" type="text/css"/>
@endsection {{-- Page Header--}}
@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header dashboard2">
        <h1>Dashboard</h1>
    </section>
@endsection {{-- Page content --}}
@section('content')
    <div class="row dashboard2">
        <div class="col-md-12">
            <div class="card" id="main-chart" style="width: 100%">
                <div class="chart-header">Recent Stats
                    <div class="btn-group float-right">
                                <span id="fullscreen-toggle" role="button">
                                    <small><i class="ti-fullscreen"></i></small>
                                </span>
                        <!--sull-screen-->
                        <span class="toggle-dropdown" role="menu" data-toggle="dropdown" aria-expanded="false"
                              aria-haspopup="true">
                                    <i class="ti-more-alt option-more"></i>
                                </span>
                        <ul class="dropdown-menu chartoption-menu">
                            <li><a href="#">View</a>
                            </li>
                            <li><a href="#">Update</a>
                            </li>
                            <li><a href="#">Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="statchart-data">
                    <div class="row">
                        <div class="data text-center">
                            <span class="percent"> 19%</span>
                            <br class="d-block d-sm-none">
                            <span>Orders</span>
                        </div>
                        <div class="data text-center">
                            <span class="percent">23%</span>
                            <br class="d-block d-sm-none">

                            <span>Sales</span>
                        </div>
                        <div class="data text-center">
                            <span class="percent">12%</span>
                            <br class="d-block d-sm-none">
                            <span>Support</span>
                        </div>
                    </div>
                </div>
                <div id="sales-chart" class='with-3d-shadow with-transitions'>
                    <svg></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="row main-cards">
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <h4><b>New Users</b></h4>
                <p>14,205
                    <small>Last month</small>
                </p>
                <span id="user-chart"></span>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <h4><b>Revenue</b></h4>
                <p>$56,180
                    <small>Target</small>
                </p>
                <span id="mr-chart"></span>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <h4><b>Hits</b></h4>
                <p>24,525
                    <small>Reached</small>
                </p>
                <h6><span class="float-right progress-label"><b>6</b><small>%</small> <i
                                class="ti-stats-up"></i></span></h6>
                <div class="progress progress-xs progress-striped active hits-progress">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="40"
                         aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <h4><b>Subscribers</b></h4>
                <p>8,958
                    <small>Quarterly</small>
                </p>
                <span id="subscriber-chart"></span>
            </div>
        </div>
    </div>
    <!--rightside bar -->

    <!-- /#right -->
    <div class="background-overlay"></div>
@endsection {{-- local scripts --}}
@section('footer_scripts')
    <!--nvd3 chart-->
    <script type="text/javascript" src="{{ asset('vendors/d3/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/nvd3/js/nv.d3.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('vendors/screenfull/js/screenfull.min.js')}}"></script>
    <!--Sparkline Chart-->
    <script src="{{asset('js/custom_js/sparkline/jquery.flot.spline.js') }}"></script>
    <!--knob-->
    <script type="text/javascript" src="{{ asset('vendors/jquery-knob/js/jquery.knob.js') }}"></script>
    <!--metrojs-->
    <script type="text/javascript" src="{{ asset('vendors/metrojs/js/MetroJs.min.js') }}"></script>
    <script src="{{ asset('js/dashboard2.js') }}" type="text/javascript"></script>
    <!-- end of page level js -->
@endsection
