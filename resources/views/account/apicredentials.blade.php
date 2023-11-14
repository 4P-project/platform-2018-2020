@extends('account.layouts.master')

@section('title', 'Api credentials')

@section('header_styles')
@endsection

@section('page-header')
    <section class="content-header">
        <h1>API credentials</h1>
    </section>
@endsection

@section('content')
    <div id="app">
        <passport-clients></passport-clients>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
@endsection
