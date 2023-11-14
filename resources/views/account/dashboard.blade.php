@extends('account.layouts.master')
{{-- Page title --}}
@section('title', 'Dashboard')
{{-- local styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{asset('vendors/nvd3/css/nv.d3.min.css')}}" rel="stylesheet" type="text/css">
    <!--weathericons-->
    <link href="{{asset('vendors/weathericon/css/weather-icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('vendors/metrojs/css/MetroJs.min.css')}}">
    <link href="{{asset('css/custom_css/dashboard2.css')}}" rel="stylesheet" type="text/css"/>
@endsection {{-- Page Header--}}
@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header dashboard2">
        <h1>Dashboard</h1>
    </section>
@endsection {{-- Page content --}}
@section('content')
    @if (session('is_corporate', false))
        @include('account.dashboard.corporate')
    @else
        @include('account.dashboard.personal')
    @endif

    <div class="background-overlay"></div>
@endsection {{-- local scripts --}}
@section('footer_scripts')
    <!--nvd3 chart-->
    <script type="text/javascript" src="{{asset('vendors/d3/d3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/nvd3/js/nv.d3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/screenfull/js/screenfull.min.js')}}"></script>
    <!--Sparkline Chart-->
    <script src="{{asset('js/custom_js/sparkline/jquery.flot.spline.js')}}"></script>
    <!--knob-->
    <script type="text/javascript" src="{{asset('vendors/jquery-knob/js/jquery.knob.js')}}"></script>
    <!--metrojs-->
    <script type="text/javascript" src="{{asset('vendors/metrojs/js/MetroJs.min.js')}}"></script>
    <script src="{{asset('js/dashboard2.js')}}" type="text/javascript"></script>
    <!-- end of page level js -->

    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
@endsection
