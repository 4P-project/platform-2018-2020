<div class="nav_profile">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="javascript:void(0)">
            <img src="{{asset('img/authors/avatar1.jpg')}}" class="rounded-circle" alt="User Image">
        </a>
        <div class="content-profile">
            <h4 class="media-heading">Addison</h4>
            <ul class="icon-list">
                <li>
                    <a href="{{url('edit_user')}}" title="settings">
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
    <li {!! (Request::is($adminRoute) ? 'class="active"': "") !!}>
        <a href="{{url($adminRoute)}}">
            <span class="mm-text ">Dashboard</span>
        </a>
    </li>
    <li {!! (Request::is($adminRoute . '/kyc/pending', $adminRoute .'/kyc/*') ? 'class="menu-dropdown active"': 'class="menu-dropdown"') !!}>
        <a href="javascript:void(0)">
            <span class="mm-text">KYC Forms</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is( $adminRoute . '/kyc/pending') ? 'class="active"' : "") !!}>
                <a href="{{ url($adminRoute . '/kyc/pending') }}">
                    <span class="mm-text">Pending</span>
                </a>
            </li>
        </ul>
    </li>
</ul>
<!-- / .navigation -->


