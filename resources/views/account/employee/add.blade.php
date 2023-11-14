@extends('account.layouts.master')
{{-- Page title --}}
@section('title', 'Dashboard')
{{-- local styles --}}
@section('header_styles')

@endsection {{-- Page Header--}}
@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header dashboard2">
        <h1>Send invitations</h1>
    </section>
@endsection {{-- Page content --}}
@section('content')
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
        Send e-mail invitation to your employees in order to have them linked with your organization's account.
    </div>
    <form method="POST" action="{{ url('mail/employee/invite') }}">
        @include('account.layouts.formerrors')
        {{ csrf_field() }}
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="control-label txt_media1">Comma separated emails</label>
            </div>
            <div class="col-sm-12">
                <textarea rows="4" name="mails" class="form-control resize_vertical" placeholder="test@gmail.com,john.stelmark@yahoo.com,jon.vein@company.at" ></textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-2">
                <input class="btn btn-success btn-lg btn-block" type="submit" value="Submit">
            </div>
        </div>
    </form>
@endsection
{{-- local scripts --}}
@section('footer_scripts')
    <!-- end of page level js -->
@endsection
