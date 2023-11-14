@extends('account.layouts.master')
{{-- Page title --}}
@section('title', 'Employee list')
{{-- local styles --}}
@section('header_styles')

@endsection {{-- Page Header--}}
@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header dashboard2">
        <h1>Employees</h1>
    </section>
@endsection {{-- Page content --}}
@section('content')
    <div class="col-sm-12">
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
            Here you can find your employees' data such as their ID and e-mail addresses.
        </div>
    </div>
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Last name</th>
                    <th>First name</th>
                    <th>Email</th>
                    <th>Wallet Address</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $employee)
                    @php $user = $employee->user @endphp
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->wallet }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
{{-- local scripts --}}
@section('footer_scripts')
    <!-- end of page level js -->
@endsection
