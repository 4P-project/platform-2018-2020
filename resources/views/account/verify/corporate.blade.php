@extends('account.layouts.master') {{-- Page title --}}
@section('title', ' Verify')
{{-- local styles --}}
@section('header_styles')
@endsection {{-- Page Header--}}
@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header dashboard2">
        <h1>CORPORATE ACCOUNT VERIFICATION</h1>
    </section>
    <link rel="stylesheet" href="{{asset('css/countrySelect.css')}}">
    <link href="{{asset('vendors/bootstrap-fileinput/css/fileinput.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/formelements.css')}}">

@endsection {{-- Page content --}}
@section('content')
    <form method="POST" action="{{ url('account/userkycs') }}" enctype="multipart/form-data">

        @include('account.layouts.formerrors')

        {{ csrf_field() }}

        <input type="hidden" name="account_type" value="{{ \App\UserKyc::KYC_FORM_TYPE_CORPORATE }}" id="account_type">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="company_name">Company name</label>
                <input type="text" class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" id="company_name" name="company_name" value="{{ old('company_name') ? old('company_name') : optional($kyc)->company_name }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('company_name') }}
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="registered_office">Registered office</label>
                <input type="text" class="form-control  {{ $errors->has('registered_office') ? 'is-invalid' : '' }}" id="registered_office" name="registered_office" value="{{ old('registered_office') ? old('registered_office') : optional($kyc)->registered_office }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('registered_office') }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="business_address">Business address</label>
                <input type="text" class="form-control  {{ $errors->has('business_address') ? 'is-invalid' : '' }}" id="business_address" name="business_address" value="{{ old('business_address') ? old('business_address') : optional($kyc)->business_address }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('business_address') }}
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="registration_number">Registration number</label>
                <input type="text" class="form-control  {{ $errors->has('registration_number') ? 'is-invalid' : '' }}" id="registration_number" name="registration_number" value="{{ old('registration_number') ? old('registration_number') : optional($kyc)->registration_number }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('registration_number') }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name_of_the_representative">Name of the representative</label>
                <input type="text" class="form-control  {{ $errors->has('name_of_the_representative') ? 'is-invalid' : '' }}" id="name_of_the_representative" name="name_of_the_representative" value="{{ old('name_of_the_representative') ? old('name_of_the_representative') : optional($kyc)->name_of_the_representative }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('name_of_the_representative') }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="country">Country of registration</label>
                <input type="hidden" id="country_code" name="country_code"/>
                <input type="text" class="form-control  {{ $errors->has('country_code') ? 'is-invalid' : '' }}" id="country" name="country" required>
                <div class="invalid-feedback">
                    {{ $errors->first('country_code') }}
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="tax_id_number">Tax ID number</label>
                <input type="text" class="form-control  {{ $errors->has('tax_id_number') ? 'is-invalid' : '' }}" id="tax_id_number" name="tax_id_number" value="{{ old('tax_id_number') ? old('tax_id_number') : optional($kyc)->tax_id_number }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('tax_id_number') }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email') ? old('email') : optional($kyc)->email }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="phone_number">Telephone number</label>
                <input type="tel" class="form-control  {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" id="phone_number" name="phone_number" value="{{ old('phone_number') ? old('phone_number') : optional($kyc)->phone_number }}" required>
                <div class="invalid-feedback">
                    {{ $errors->first('phone_number') }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-primary">Submit your KYC Information</button>
            </div>
        </div>
    </form>

@endsection {{-- local scripts --}}
@section('footer_scripts')
    <script>
        jQuery(function() {
            $('#country').countrySelect({
                preferredCountries: ['{{old('country_code') ? old('country_code') : 'de'}}']
            });

            $('#file').fileinput({
                browseClass: 'btn btn-primary btn-block',
                showCaption: false,
                showRemove: false,
                showUpload: false
            });

        });
    </script>
    <script type="text/javascript" src="{{ asset('js/countrySelect.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
@endsection

