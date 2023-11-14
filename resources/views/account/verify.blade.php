@php
    /**
     * @var \App\UserKyc $kyc
     * @var \App\User $user
     */
@endphp
@extends('account.layouts.master')
{{-- Page title --}}
@section('title', 'Verify')
{{-- local styles --}}
@section('header_styles')
@endsection
{{-- Page Header--}}
@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header dashboard2">
        <h1>Verify Account</h1>
    </section>
@endsection {{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if($kyc && $kyc->status == $kyc::STATUS_CONFIRMED)
                <div class="text-center alert alert-success">
                    <h3 class="no-margin">STATUS: CONFIRMED</h3>
                </div>
            @elseif($kyc && $kyc->status == $kyc::STATUS_PENDING)
                <div class="text-center alert alert-warning">
                    <h3 class="no-margin">STATUS: PENDING</h3>
                </div>
            @else
                <div class="text-center alert alert-warning">
                    <h3 class="no-margin">STATUS: UNVERIFIED</h3>
                </div>
                @if($kyc && $kyc->message)
                    <div class="text-center alert alert-information">
                        <h3 class="no-margin">{{ $kyc->message }}</h3>
                    </div>
                @endif
            @endif
        </div>
    </div>

    @if(!$kyc || ($kyc->status != $kyc::STATUS_CONFIRMED && $kyc->status != $kyc::STATUS_PENDING))
        <div class="row">
            <div class="col-lg-12">
                <p>
                    If you represent the organization, please proceed with clicking »organization account verification«.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <a href="{{asset('account/verify/corporate')}}" class="verify-corporate">
                    <div class="btn btn-primary btn-lg btn-block">
                        <span>ORGANIZATIONS ACCOUNT VERIFICATION</span>
                    </div>
                </a>
            </div>
        </div>
    @endif
@endsection
{{-- local scripts --}}
@section('footer_scripts')
@endsection
