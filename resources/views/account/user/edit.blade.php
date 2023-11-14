@extends('account.layouts.master')
{{-- Page title --}}
@section('title', 'Edit')
{{-- local styles --}}
@section('header_styles')

@endsection {{-- Page Header--}}
@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header dashboard2">
        <h1>Account</h1>
    </section>
@endsection {{-- Page content --}}
@section('content')
    <form method="post" action="{{ route('account.update', [$user->id]) }}">
        @include('account.layouts.formerrors')
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="first_name">First name</label>
                <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('first_name') }}
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="last_name">Last name</label>
                <input type="text" class="form-control  {{ $errors->has('last_name') ? 'is-invalid' : '' }}" id="last_name" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('last_name') }}
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email') ? old('email') : $user->email}}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-2">
                <a class="btn btn-default btn-lg btn-block" href="{{ url()->previous() }}">Cancel</a>
            </div>
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
