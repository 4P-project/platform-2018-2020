<div class="nav_profile">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="javascript:void(0)">
            <img src="{{asset('img/authors/avatar-default.png')}}" class="rounded-circle" alt="User Image">
        </a>
        <div class="content-profile">
            <h4 class="media-heading">{{ auth()->user()->first_name }}</h4>
            <ul class="icon-list">
                <li>
                    <a href="{{ action('AccountController@edit') }}" title="settings">
                        <i class="fa fa-fw ti-settings"></i>
                    </a>
                </li>
                <li>
                    <a href="{{url('logout')}}" title="Logout">
                        <i class="fa fa-fw ti-shift-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<ul class="navigation slimmenu" id="navigation">
    <li {!! (Request::is('account') ? 'class="active"': "") !!}>
        <a href="{{url('/account')}}">
            <span class="mm-text ">Dashboard</span>
        </a>
    </li>
    <li {!! (Request::is( 'account/verify', 'account/verify/personal', 'account/verify/corporate') ? 'class="menu-dropdown active"': 'class="menu-dropdown"') !!}>
        <a href="javascript:void(0)">
            <span class="mm-text">Verify Account</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is( 'account/verify', 'account/verify/personal', 'account/verify/corporate')? 'class="active"': "") !!}>
                <a href="{{url('account/verify')}}">
                    <span class="mm-text">Identity verification</span>
                </a>
            </li>
        </ul>
    </li>
    @if (session('is_corporate', false))
        <li {!! (Request::is('account/employee/add', 'account/employee/list') ? 'class="menu-dropdown active"': 'class="menu-dropdown"') !!}>
            <a href="javascript:void(0)">
                <span class="mm-text">Employees</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {!! (Request::is( 'account/employee/add')? 'class="active"': "") !!}>
                    <a href="{{url('account/employee/add')}}">
                        <span class="mm-text">Add</span>
                    </a>

                </li>
                <li {!! (Request::is('account/employee/list')? 'class="active"': "") !!}>
                    <a href="{{url('account/employee/list')}}">
                        <span class="mm-text">List</span>
                    </a>

                </li>
            </ul>
        </li>
        <li {!! (Request::is('account/apicredentials') ? 'class="active"': "") !!}>
            <a href="{{ url('account/apicredentials') }}">
                <span class="mm-text ">API Credentials</span>
            </a>
        </li>
    @endif
    <li {!! (Request::is('account/wallet') ? 'class="active"': "") !!}>
        <a href="{{ url('account/wallet') }}">
            <span class="mm-text ">Wallet</span>
        </a>
    </li>
    <li {!! (Request::is('account/documents', 'account/documents/send') ? 'class="menu-dropdown active"': 'class="menu-dropdown"') !!}>
        <a href="javascript:void(0)">
            <span class="mm-text">Documents</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('account/documents')? 'class="active"': "") !!}>
                <a href="{{ url('account/documents') }}">
                    <span class="mm-text">View</span>
                </a>
            </li>
            <li {!! (Request::is('account/documents/send')? 'class="active"': "") !!}>
                <a href="{{ url('account/documents/send') }}">
                    <span class="mm-text">Send</span>
                </a>
            </li>
        </ul>
    </li>
    <li {!! (Request::is('account/payment') ? 'class="active"': "") !!}>
        <a href="{{ url('account/payment') }}">
            <span class="mm-text ">Buy tokens</span>
        </a>
    </li>
    <li {!! (Request::is('account/orders') ? 'class="active"': "") !!}>
        <a href="{{ url('account/orders') }}">
            <span class="mm-text ">Orders</span>
        </a>
    </li>
</ul>
<!-- / .navigation -->


