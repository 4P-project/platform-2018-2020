@php $adminRoute = env('ADMIN_ROUTE', 'admin') @endphp
@extends('admin.layouts.master')
{{-- Page title --}}
@section('title', 'Dashboard')
{{-- local styles --}}
@section('header_styles')
    <!--page level css -->
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-table/css/bootstrap-table.min.css') }}">
    <link href="{{ asset('vendors/bootstrap-magnify/css/bootstrap-magnify.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/buttons_sass.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/animate/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom_css/advanced_modals.css') }}">

@endsection {{-- Page Header--}}
@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header dashboard2">
        <h1>View</h1>
    </section>
@endsection {{-- Page content --}}
@section('content')

    <div class="form-row">
        <button class="button button-rounded button-caution-flat hvr-float" data-toggle="modal" data-target="#form_modal">Reject</button>

        <div class="form-group col-sm-2">
            <form method="post" action="{{action('UserkycsController@update', [$kyc->id])}}">
                {{ csrf_field() }}
                @method('PUT')
                <input type="hidden" name="status" value="{{ \App\UserKyc::STATUS_CONFIRMED }}">
                <input type="submit" class="button button-rounded button-royal-flat hvr-float" name="halo" value="Submit">
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-5">
            <table class="table table-striped table-bordered table-responsive">
                @foreach($kyc->toArray() as $key => $value)
                    <tr>
                        <td class="text-right">{{ strtoupper($key) }}</td>
                        <td>{{ $value }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div id="form_modal" class="modal fade animated" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                    <h4 class="modal-title">Reject KYC form </h4>
                </div>
                <form method="post" action="{{action('UserkycsController@update', [$kyc->id])}}">
                    {{ csrf_field() }}
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ \App\UserKyc::STATUS_ERROR }}">
                    <div class="modal-body">
                        <div class="row m-t-10">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="sr-only" for="message">Message</label>
                                    <textarea
                                            class="form-control resize_vertical m-t-10"
                                            name="message"
                                            placeholder="Message" rows="6"
                                            id="message"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-succes">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
{{-- local scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendors/bootstrap-table/js/bootstrap-table.min.js') }}"></script>
    <script src="{{asset('vendors/bootstrap-magnify/js/bootstrap-magnify.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/custom_js/advanced_modals.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#pending_table').bootstrapTable();
        });
    </script>
@endsection
