@extends('account.layouts.master')

@section('title', 'Send document')

@section('header_styles')
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Send document</h1>
    </section>
@endsection

@section('content')
    <div id="app">
        <document-send></document-send>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    <script>

    </script>
@endsection
