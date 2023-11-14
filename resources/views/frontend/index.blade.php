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
<body data-spy="scroll" data-target="#mainmenu" data-offset="50">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an
    <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
</p>
<![endif]-->

<div class="preloade">
    <span><i class="ti-mobile"></i></span>
</div>

<!--Header-Area-->
<header class="blue-bg relative fix" id="home">
    <div class="section-bg overlay-bg dewo ripple"></div>
    <!--Mainmenu-->
    <nav class="navbar navbar-default mainmenu-area navbar-fixed-top" data-spy="affix" data-offset-top="60">
        <div class="container">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" class="navbar-toggle" data-target="#mainmenu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="{{ url('/') }}" class="navbar-brand">
                    <img src="{{ url('frontend/images/logo.png') }}" alt="The 4th Pillar logo">
                </a>
            </div>
            <div class="collapse navbar-collapse navbar-right" id="mainmenu">
                <ul class="nav navbar-nav">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#work">How It Works</a></li>
                    <li><a href="#team">Team</a></li>
                    <li><a href="#client">Adopters</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li>
                        <a href="{{ url('login') }}" class="login login-btn">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<!--Mainmenu/-->
    <div class="space-100"></div>
    <div class="space-20 hidden-xs"></div>
    <!--Header-Text-->
    <div class="container text-white">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="space-100"></div>
                <h1>THE 4TH PILLAR - CHANGING THE WAY
                    <br/>HR INDUSTRY WORKS TODAY</h1>
                <div class="space-10"></div>
                <h4>It’s a blockchain-based HR & financial solutions hub that allows you to make multiple wallet transfers.</h4>
                <div class="space-50"></div>
                <a href="https://www.youtube.com/watch?v=uB_uZtZMBUA" class="btn btn-icon video-popup"><span class="ti-control-play"></span>Watch Video</a>
            </div>
            <div class="hidden-xs hidden-sm col-md-4">
                <div class="home_screen_slide">
                    <div class="single_screen_slide wow fadeInRight">
                        <div class="item">
                            <img src="{{ url('frontend/images/screen/screen1.jpg') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ url('frontend/images/screen/screen2.jpg') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ url('frontend/images/screen/screen3.jpg') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ url('frontend/images/screen/screen4.jpg') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ url('frontend/images/screen/screen5.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="home_screen_nav">
                    <span class="ti-angle-left testi_prev"></span>
                    <span class="ti-angle-right testi_next"></span>
                </div>
            </div>
        </div>
        <div class="space-80"></div>
    </div>
    <!--Header-Text/-->
</header>
<!--Header-Area/-->
<section>
    <div class="space-80"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="well well-hover text-center">
                    <p class="md-icon"><span class="ti-wallet"></span></p>
                    <div class="space-10"></div>
                    <h5 class="text-uppercase">4TH PILLAR WALLET</h5>
                    <p>Individual control and management over received digital assets and work-related documentation.</p>
                </div>
            </div>
            <div class="col-xs-12 col-md-4 wow fadeInUp" data-wow-delay="0.4s">
                <div class="well well-hover text-center">
                    <p class="md-icon">
                        <span class="ti-layout-grid2-thumb"></span></p>
                    <div class="space-10"></div>
                    <h5 class="text-uppercase">4TH PILLAR DATABASE</h5>
                    <p>Blockchain personal ledger identity database with automatic non-discriminatory professional identity evaluation.</p>
                </div>
            </div>
            <div class="col-xs-12 col-md-4 wow fadeInUp" data-wow-delay="0.6s">
                <div class="well well-hover text-center">
                    <p class="md-icon"><span class="ti-files"></span></p>
                    <div class="space-10"></div>
                    <h5 class="text-uppercase">4TH PILLAR DOCUMENT DISTRIBUTION</h5>
                    <p>Work-related document through peer-to-peer distribution.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="space-80"></div>
</section>
<!--Work-Section-->

<section class="gray-bg" id="work">
    <div class="space-80"></div>
    <div class="container">
        <div class="row wow fadeInUp">
            <div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
                <h3 class="text-uppercase">How it works?</h3>
                <p>It enables you to control your personal savings crypto-fund as well as receive and send cross border payments and other work-related documentation.
                    <br>It uses the FOUR token as main value to fuel the 4th pillar ecosystem.
                </p>
            </div>
        </div>
        <div class="space-60"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 text-center tooltips" title="FOUR token provides access to professional identity verification-related services and serves as main value and gas in a decentralized, token-based ecosystem. It is a permanent 100% utility token. FOUR token also represents a unit on the network. The bigger the network grows the more utility in the token. As the adoption of the 4th Pillar network and FOUR token transaction volumes within grows, this creates and drives further demand for the FOUR tokens.">
                <div class="space-60">
                    <img src="{{ url('frontend/images/icon/icon1.png') }}" alt="">
                </div>
                <div class="space-20"></div>
                <h5 class="text-uppercase">FOUR TOKEN</h5>
                <p>FOUR token provides access to your digital professional identity and serves as main value.</p>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 text-center tooltips" title="A blockchain is a decentralized, distributed and public digital ledger that is used to record transactions across many computers so that the records cannot be altered. This technology has given us the opportunity to move far beyond limitations that HR business were facing for the past 70 years. By using blockchain you can easily transfer pay slips and work-related documentation in a safe and transparent way.">
                <div class="space-60">
                    <img src="{{ url('frontend/images/icon/icon2.png') }}" alt="">
                </div>
                <div class="space-20"></div>
                <h5 class="text-uppercase">BLOCKCHAIN TECHNOLOGY</h5>
                <p>Blockchain enables transparent and secure peer-to-peer transactions within a click of a mouse.</p>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 text-center tooltips" title="P2P transactions is what drives and builds the blockchain system. It allows you to connect with other people directly. DAAP (decentralised application) will enable transfer and management of FOUR tokens, working Blochchain HR database and peer to peer transfer of pay slips and work-related documents.">
                <div class="space-60">
                    <img src="{{ url('frontend/images/icon/icon3.png') }}" alt="">
                </div>
                <div class="space-20"></div>
                <h5 class="text-uppercase">P2P DISTRIBUTION</h5>
                <p>Peer-to-peer (P2P) enables you to send and receive documents as well as make transactions.</p>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 text-center tooltips" title="InterPlanetary File System (IPFS) is a peer-to-peer file distribution that connects to computing devices with the same system of files. It is a protocol and network, designed to create a content-addressable, peer-to-peer method of storing and sharing hypermedia and a distributed file system. That way all of your personal data and documentation is safely stored in one place. In other words, IPFS provides a high-throughput, content-addressed block storage, with content-addressed hyperlinks.">
                <div class="space-60">
                    <img src="{{ url('frontend/images/icon/icon4.png') }}" alt="">
                </div>
                <div class="space-20"></div>
                <h5 class="text-uppercase">IPFS</h5>
                <p>InterPlanetary File System (IPFS) enables a safe and protected way of storing information.</p>
            </div>
        </div>
        <div class="space-60"></div>
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2 text-center wow fadeInUp">
                <div class="down-offset ">
                    <img src="{{ url('frontend/images/mobile1.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!--Work-Section/-->

<!--Team-Section-->
<section id="team">
    <div class="space-80"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
                <h3 class="text-uppercase">The 4<sup>th</sup> Pillar main team
                </h3>
                <p>The 4th Pillar team is our biggest advantage. From professionally skilled founders, efficient and reliable employees, to expert advisors we can really say we have the best team.</p>
            </div>
        </div>
        <div class="space-60"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="single-team relative panel fix">
                    <img src="{{ url('frontend/images/team/tali-rezun.jpg') }}" alt="">
                    <div class="team_details text-center">
                        <h5 class="text-uppercase">Tali Rezun</h5>
                        <p>Co-founder, CEO</p>
                        <div class="social-menu">
                            <hr>
                            <a href="https://www.linkedin.com/in/talirezun" target="_blank"><span class="ti-linkedin"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 wow fadeInUp" data-wow-delay="0.4s">
                <div class="single-team relative panel fix">
                    <img src="{{ url('frontend/images/team/dusan-lazar.jpg') }}" alt="">
                    <div class="team_details text-center">
                        <h5 class="text-uppercase">Dusan Lazar</h5>
                        <p>Co-founder, COO</p>
                        <div class="social-menu">
                            <hr>
                            <a href="https://www.linkedin.com/in/dusanlazar" target="_blank"><span class="ti-linkedin"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 wow fadeInUp" data-wow-delay="0.6s">
                <div class="single-team relative panel fix">
                    <img src="{{ url('frontend/images/team/roman-dobrina.jpg') }}" alt="">
                    <div class="team_details text-center">
                        <h5 class="text-uppercase">Roman Dobrina</h5>
                        <p>Co-founder, CFO</p>
                        <div class="social-menu">
                            <hr>
                            <a href="https://www.linkedin.com/in/roman-dobrina-b7462640" target="_blank"><span class="ti-linkedin"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 wow fadeInUp" data-wow-delay="0.8s">
                <div class="single-team relative panel fix">
                    <img src="{{ url('frontend/images/team/jaka-gornik.jpg') }}" alt="">
                    <div class="team_details text-center">
                        <h5 class="text-uppercase">Jaka Gornik</h5>
                        <p>Co-founder, CMO</p>
                        <div class="social-menu">
                            <hr>
                            <a href="https://www.linkedin.com/in/jakagornik" target="_blank"><span class="ti-linkedin"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <center>
            <a href=https://www.the4thpillar.io/team/ target="_blank">View all team member</a>
        </center>
    </div>
    <div class="space-80"></div>
</section>
<!--Team-Section/-->

<!-- Client-Section -->
<section id="client">
    <div class="space-80"></div>
    <div class="container">
        <div class="row wow fadeInUp">
            <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
                <div class="well well-lg">
                    <div class="client-details-content">
                        <div class="client_details">
                            <div class="item">
                                <h3>ANTON ROP</h3>
                                <q>Based on my past experience I can say that The 4th Pillar platform is
                                    genuinely unique. It is the place that enables individuals to build verified professional
                                    identity and allows them to connect with current and potential future employers. I have no
                                    hesitation in recommending it highly. </q>
                            </div>
                            <div class="item">
                                <h3>ZZI</h3>
                                <q>I see amazing possibilities in The 4th Pillar platform. To serve as a
                                    system based on BlockChain technology for formal document delivery from organizations to
                                    individuals. A truly innovative solution.</q><br>- Igor Zorko
                            </div>
                            <div class="item">
                                <h3>GREY</h3>
                                <q>We strongly support the project as we have stepped in as one of the
                                    early adopters and believers in the blockchain based HR platform. Therefore, The 4th Pillar’s
                                    potential is not only enormous and more input rather than experience, but does it also
                                    quickly and at scale.</q><br>-Nikola Bubanj
                            </div>
                            <div class="item">
                                <h3>NATON</h3>
                                <q>A non-discriminatory evaluation system and database, where just
                                    one click separates us from finding a perfect employee. Seems like a dream come true. I
                                    truly believe, that The 4th Pillar project with its platform, is an incredible tool for al HR
                                    recruiters our there. I simply can&#39;t wait to start using it.</q><br>- Brane Parazajda
                            </div>
                            <div class="item">
                                <h3>WORK SERVICE</h3>
                                <q>I would like to give my personal recommendation to The 4th Pillar
                                    concept. Based on all my experiences I can say that The 4th Pillar concept is really unique
                                    and can make a difference in HR going forward.</q><br>- Wojciech Mora
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-40"></div>
        <div class="row wow fix fadeInUp">
            <div class="col-xs-12 col-md-6 col-md-offset-3 relative">
                <div class="client-photo-list">
                    <div class="client_photo">
                        <div class="item">
                            <div class="box100">
                                <img src="{{ url('frontend/images/client/client1.png') }}" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="box100">
                                <img src="{{ url('frontend/images/client/client2.png') }}" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="box100">
                                <img src="{{ url('frontend/images/client/client3.png') }}" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="box100">
                                <img src="{{ url('frontend/images/client/client4.png') }}" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="box100">
                                <img src="{{ url('frontend/images/client/client5.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="client_nav">
                    <span class="ti-angle-left testi_prev"></span>
                    <span class="ti-angle-right testi_next"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="space-80"></div>
</section>
<!-- Client-Section- ->

<!--Question-section-->
<section class="fix">
    <div class="space-80"></div>
    <div class="container">
        <div class="row wow fadeInUp">
            <div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
                <h3 class="text-uppercase">Frequently asked questions</h3>
            </div>
        </div>
        <div class="space-60"></div>
        <div class="row">
            <div class="col-xs-12 col-md-6 wow fadeInUp">
                <div class="space-60"></div>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">WHAT IS THE 4TH PILLAR PROJECT?</a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body">The 4th Pillar project is a privately and publicly funded blockchain-based human resources and finance connecting platform for individuals and organizations. Based on the Ethereum blockchain and teleportation service, the platform will utilize smart contracts, digital wallets and IPFS protocol to solve day-to-day problems experienced by individuals and their employers. For example, 4th Pillar will offer solutions to: (1) expensive international bank payments, bonus transfers, and; (2) work-related peer-to-peer sensitive document distribution. The 4th Pillar platform will enable individuals to build a verified professional identity and their personal decentralized savings and pension fund. Organizations will optimize their finances and recruit potential employees using a professional database with a validated, automated, non-discriminatory evaluation system.</div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">WHO IS THE PLATFORM MEANT FOR?</a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">The 4th Pillar platform is meant for individuals, organizations and HR recruiters. It will enable quick and easy peer-to-peer communication between two parties with a click of a mouse.</div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">HOW CAN I CONTACT YOU?</a>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>
                                    The 4th Pillar project offers customer services to individuals through the Telegram channel – please join
                                    <a href="https://t.me/joinchat/Hv2QVBEi2yIsGK62l9szpw" target="_blank">https://t.me/joinchat/Hv2QVBEi2yIsGK62l9szpw</a>
                                </p>
                                <p>
                                    Email:
                                    <a href="mailto:info@the4thpillar.com">info@the4thpillar.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden-xs hidden-sm col-md-5 col-md-offset-1 wow fadeInRight ">
                <img src="{{ url('frontend/images/2mobile.png') }}" alt="">
            </div>
        </div>
    </div>
    <div class="space-80"></div>
</section>
<!--Question-section/-->

<!--Download-Section-->
<section class="relative fix">
    <div class="space-80"></div>
    <div class="section-bg overlay-bg">

    </div>
    <div class="container">
        <div class="row wow fadeInUp">
            <div class="col-xs-12 col-md-6 col-md-offset-3 text-center text-white">
                <h3 class="text-uppercase">LOGIN TO OUR PLATFORM</h3>
            </div>
        </div>
        <div class="space-60"></div>
        <div class="row text-white wow fadeInUp">
            <div class="col-xs-12 col-sm-12">
                <a href="{{ url('login') }}" class="big-button aligncenter login-btn" style="padding-left: 70px;">
                    <strong>Login</strong>
                </a>
                <div class="space-10"></div>
            </div>
        </div>
    </div>
    <div class="space-80"></div>
</section>
<!--Download-Section/-->

<!--Map-->
<div id="contact"></div>
<div id="maps"></div>
<!--Map/-->
<!--Footer-area-->
<footer class="black-bg">
    <div class="container">
        <div class="row">
            <div class="offset-top">
                <div class="col-xs-12 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="well well-lg">
                        <h3>Get in Touch</h3>
                        <div class="space-20"></div>
                        <form action="{{ action('MailController@mailToAdmin') }}" method="post">
                            @include('account.layouts.formerrors')
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="form-name" class="sr-only">Name</label>
                                        <input type="text" class="form-control" id="form-name" name="name" placeholder="Name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="space-10"></div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="form-email" class="sr-only">Email</label>
                                        <input type="email" class="form-control" id="form-email" name="email" placeholder="Email" value="{{ old('email') }}"  required>
                                    </div>
                                    <div class="space-10"></div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="form-subject" class="sr-only">Email</label>
                                        <input type="text" class="form-control" id="form-subject" name="subject" placeholder="Subject" value="{{ old('subject') }}"  required>
                                    </div>
                                    <div class="space-10"></div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="form-message" class="sr-only">comment</label>
                                        <textarea class="form-control" rows="6" id="form-message" name="message" placeholder="Message"  required>{{ old('message') }}</textarea>
                                    </div>
                                    <div class="space-10"></div>
                                    <button class="btn text-uppercase" type="submit">Send message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="well well-lg">
                        <h3>Address</h3>
                        <div class="space-20"></div>

                        <div class="space-25"></div>
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="border-icon sm">
                                        <span class="ti-info"></span>
                                    </div>
                                </td>
                                <td>
                                    The 4<sup>th</sup> Pillar ltd
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="border-icon sm">
                                        <span class="ti-email"></span></div>
                                </td>
                                <td>
                                    <a href="mailto:info@the4thpillar.com">info@the4thpillar.com</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="border-icon sm">
                                        <span class="ti-location-pin"></span>
                                    </div>
                                </td>
                                <td>
                                    <address>
                                        Cesta 24. julija 25<br>
                                        1000 Ljubljana<br>
                                        Slovenia<br>
                                        Europe
                                    </address>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-80"></div>
        <div class="row text-white wow fadeIn">
            <div class="col-xs-12 text-center">
                <div class="space-20"></div>
                <p>@ 2018 The 4<sup>th</sup> Pillar ltd.<br>All right reserved.
                </p>
            </div>
        </div>
        <div class="space-20"></div>
    </div>
</footer>
<!--Footer-area-->

<!--Maps JS-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTS_KEDfHXYBslFTI_qPJIybDP3eceE-A&sensor=false"></script>

<!--App JS-->
<script src="{{ url('frontend/js/app.js') }}"></script>

@include('account.layouts.notifications')

<script>
    $(document).ready(function() {
        $('.tooltips').tooltipster({
            theme: 'tooltipster-shadow',
            maxWidth: 350,
        });
    });
</script>
</body>
</html>
