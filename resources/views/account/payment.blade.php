@extends('account.layouts.master')

@section('title', 'Buy tokens')

@section('header_styles')
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Buy tokens</h1>
    </section>
@endsection

@section('content')
    <div id="app">
        <div class="container">
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="amount">Amount €</label>
                    <input type="text" class="form-control" id="amount" name="amount"  placeholder="Amount in €" required="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div id="dropin-container"></div>
                    <button id="submit-button">Request payment method</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/braintree/dropin.js') }}" type="text/javascript"></script>

    <script>
        var button = document.querySelector('#submit-button');
        braintree.dropin.create({
            authorization: "{{ Braintree_ClientToken::generate() }}",
            container: '#dropin-container',
            // paypal: {
            //     flow: 'vault'
            // },

        }, function(createErr, instance) {
            button.addEventListener('click', function() {
                instance.requestPaymentMethod(function(err, payload) {
                    let amount = $('#amount').val();
                    $.get('{{ url('account/processPayment') }}', {payload, amount: amount}, function(response) {
                        if (response.success) {
                            alert('Payment successfull!');
                            window.location.href = "/account/orders";
                        } else {
                            alert('Payment failed');
                        }
                    }, 'json');
                });
            });
        });
    </script>
@endsection