@php $adminRoute = env('ADMIN_ROUTE', 'admin') @endphp
@extends('admin.layouts.master')
{{-- Page title --}}
@section('title', 'Pending KYCs')
{{-- local styles --}}
@section('header_styles')
    <!--page level css -->
    <link rel="stylesheet" href="{{asset('vendors/bootstrap-table/css/bootstrap-table.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom_css/bootstrap_tables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/jasny-bootstrap/css/jasny-bootstrap.css')}}">
@endsection {{-- Page Header--}}
@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header dashboard2">
        <h1>Pending KYC forms</h1>
    </section>
@endsection
{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card-body">
                <table id="pending_table" class="table table-striped table-bordered rowlink" data-link="row"
                       data-toolbar="#toolbar"
                       data-search="false"
                       data-show-refresh="true"
                       data-show-toggle="false"
                       data-show-columns="true"
                       data-minimum-count-columns="2"
                       data-show-pagination-switch="true"
                       data-pagination="true"
                       data-id-field="id"
                       data-page-list="[10,20,40]"
                       data-show-footer="false"
                       data-side-pagination="server"
                       data-url="/{{$adminRoute}}/kyc/filterdata"
                       data-query-params="postQueryParams">
                    <thead>
                    <tr>
                        <th data-field="id" data-visible="true" data-formatter="urlFormatter" data-sortable="true">#</th>
                        <th data-field="company_name" data-sortable="true">Company name</th>
                        <th data-field="registered_office" data-sortable="true">Registered Office</th>
                        <th data-field="business_address" data-sortable="true">Business Address</th>
                        <th data-field="tax_id_number" data-sortable="true">Tax Id Number</th>
                        <th data-field="phone_number" data-sortable="true">Phone Number</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
{{-- local scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{asset('vendors/editable-table/js/mindmup-editabletable.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/bootstrap-table/js/bootstrap-table.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/jasny-bootstrap/js/jasny-bootstrap.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#pending_table').bootstrapTable();
            $(".columns-right .btn-default:nth-child(2) i").removeClass("glyphicon glyphicon-list-alt").addClass("fa fa-refresh");
            $(".columns-right .btn-default:eq(0) i").removeClass("glyphicon glyphicon-collapse-down").addClass("fa fa-chevron-circle-down");
            $(".columns-right .btn-default:eq(0)").on("click", function() {
                if ($(".columns-right .btn-default:eq(0) i").hasClass("glyphicon glyphicon-collapse-up")) {
                    $(".columns-right .btn-default:eq(0) i").removeClass("glyphicon glyphicon-collapse-up").addClass("fa fa-chevron-circle-up")
                }
                else {
                    $(".columns-right .btn-default:eq(0) i").removeClass("glyphicon glyphicon-collapse-down").addClass("fa fa-chevron-circle-down")
                }
            });

            // Refresh data table
            setInterval(refreshTable, 5000);
        });

        function postQueryParams(params) {
            params.status = '{{ \App\UserKyc::STATUS_PENDING }}';
            return params;
        }

        function urlFormatter(value, row, index, field) {
            return '<a href="/{{$adminRoute}}/kyc/' + value + '"></a>' + value;
        }


        function refreshTable() {
            $('#pending_table').bootstrapTable('refresh', {silent: true});
        }

    </script>
@endsection
