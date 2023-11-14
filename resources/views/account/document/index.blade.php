@extends('account.layouts.master')

@section('title', 'Documents')

@section('header_styles')
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Documents</h1>
    </section>
@endsection

@section('content')
    <div id="app">
        <documents-view></documents-view>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    <script>

    </script>
@endsection
