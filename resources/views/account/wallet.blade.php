@extends('account.layouts.master')

@section('title', 'Wallet')

@section('header_styles')
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Wallet</h1>
    </section>
@endsection

@section('content')
    <div id="app">
        @if (session('is_corporate', false))
            <organizations-wallet></organizations-wallet>
        @else
            <personal-wallet></personal-wallet>
        @endif
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    <script>

    </script>
@endsection
