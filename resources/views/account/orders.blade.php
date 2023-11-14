@extends('account.layouts.master')

@section('title', 'Orders')

@section('header_styles')
@endsection

@section('page-header')
    <section class="content-header">
        <h1></h1>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti-menu"></i> Invoices {{ $invoices->count() }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Total amount</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ $invoice->date() }}</td>
                                    <td>{{ $invoice->total() }}</td>
                                    <td>
                                        <a href="/account/invoice/{{ $invoice->id }}">Download</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script>

    </script>
@endsection