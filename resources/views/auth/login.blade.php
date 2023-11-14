<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>The 4th Pillar Platform Beta</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" href="{{ url('frontend/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" type="image/ico" href="{{ url('frontend/images/favicon.ico') }}"/>

    <link rel="stylesheet" href="{{ url('frontend/css/app.css') }}">
</head>
<body>
<header class="overlay-bg relative fix">
    <!--Mainmenu-->
    <nav class="navbar navbar-default mainmenu-area">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ url('/') }}" class="navbar-brand">
                    <img src="{{ url('frontend/images/logo.png') }}" alt="The 4th Pillar logo">
                </a>
            </div>
            <div class="collapse navbar-collapse navbar-right" id="mainmenu">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}#home">Home</a></li>
                    <li><a href="{{ url('/') }}#work">How It Works</a></li>
                    <li><a href="{{ url('/') }}#team">Team</a></li>
                    <li><a href="{{ url('/') }}#client">Adopters</a></li>
                    <li><a href="{{ url('/') }}#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--Mainmenu/-->
</header>
<div id="app">
    <!-- No web3 provider -->
    <section v-if="error === ERRORS.NO_WEB3_PROVIDER" class="yellow-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="space-100"></div>
                    <h2>Please install our Add-on and refresh the page</h2>
                    <div class="space-10"></div>
                    <h4>
                        <a href="https://www.the4thpillar.com/extension/The4thPillar-0.1.1.zip" target="_blank">Chrome: https://www.the4thpillar.com/extension/The4thPillar-0.1.1.zip</a>
                    </h4>
                    <div class="space-50"></div>
                    <div>
                        <h4>Steps for installation:</h4>
                        <ol>
                            <li>Download .zip file from the link above</li>
                            <li>Extract downloaded .zip file</li>
                            <li>In chrome go to Window - Extensions</li>
                            <li>On the right side, on extensions page, enable developer mode</li>
                            <li>Then click "Load unpacked" and select extracted directory (from 2. step)</li>
                            <li>Now you have installed extension, you can see icon on the right side</li>
                            <li>Click on that icon and setup you wallet</li>
                            <li>Refresh page</li>
                        </ol>
                    </div>
                    <div class="space-100"></div>
                </div>
            </div>
        </div>

    </section>

    <!-- Web3 is not injected - needs to login -->
    <div v-else-if="!isInjected">
        <section class="yellow-bg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="space-50"></div>
                        <h2>Please Login to our Add-on and refresh the page.</h2>
                        <div class="space-40"></div>
                    </div>
                </div>
            </div>
        </section>
        <!--<section class="gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="space-50"></div>
                        <h3 class="text-uppercase text-center">Login with MetaMask (step by step)</h3>
                        <div class="space-40"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <h4>1. Accept:</h4>
                            <div class="text-center">
                                <img src="{{ url('frontend/images/login/metamask_1.png') }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h4>2. Scroll down and accept:</h4>
                            <div class="text-center">
                                <img src="{{ url('frontend/images/login/metamask_2.png') }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h4>3. Choose new password and confirm (+ save it somewhere safe):</h4>
                            <div class="text-center">
                                <img src="{{ url('frontend/images/login/metamask_3.png') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <h4>4. Choose KOVAN test Network:</h4>
                            <div class="text-center">
                                <img src="{{ url('frontend/images/login/metamask_4.png') }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h4>5. Copy 12 words seed somewhere safe:</h4>
                            <div class="text-center">
                                <img src="{{ url('frontend/images/login/metamask_5.png') }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h4>6. Login with METAMASK – Sign!</h4>
                            <div class="text-center">
                                <img src="{{ url('frontend/images/login/metamask_6.png') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>-->
    </div>

    <!-- Login button -->
    <div v-else>
        <section class="yellow-bg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="space-50"></div>
                        <h4>The 4th Pillar does not hold your keys for you. We cannot access accounts, recover keys, reset passwords, nor reverse transactions. Protect your keys & always check that you are on correct URL. You are responsible for your security.</h4>
                        <div class="space-40"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="space-50"></div>
                        <div class="text-center">
                            <button class="main-login-btn" onClick="login()">Login</button>
                        </div>
                        <div class="space-50"></div>
                        <div>
                            <h4>Do you want to try our Add-on for chrome?</h4>
                            Here is the link: <a href="https://www.the4thpillar.com/extension/The4thPillar-0.1.1.zip" target="_blank">https://www.the4thpillar.com/extension/The4thPillar-0.1.1.zip</a>
                        </div>
                        <div class="space-50"></div>
                        <div>
                            <h5>Steps for installation:</h5>
                            <ol>
                                <li>Download .zip file from the link above</li>
                                <li>Extract downloaded .zip file</li>
                                <li>In chrome go to Window - Extensions</li>
                                <li>On the right side, on extensions page, enable developer mode</li>
                                <li>Then click "Load unpacked" and select extracted directory (from 2. step)</li>
                                <li>Now you have installed extension, you can see icon on the right side</li>
                                <li>Click on that icon and setup you wallet</li>
                                <li>Refresh page</li>
                            </ol>
                        </div>
                        <div class="space-50"></div>
                        <div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
                            If you are interested in testing our beta version of the platform, please send us an e-mail to: <a href="mailto:verification@the4thpillar.com">verification@the4thpillar.com</a> in order to get verified and receive test FOUR tokens. After that, you will be able to login.
                        </div>
                        <div class="space-50"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="{{ asset('frontend/js/login.js') }}" type="text/javascript"></script>
<script>
    function login() {
        Web3Auth.login('{{ config('app.sign_message') }}', '{{ url('login') }}', function(response) {
            console.log(response);
        });
    }
</script>
</body>
</html>
