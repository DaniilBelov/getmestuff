<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                <div>
                    <img src="http://orig15.deviantart.net/8f30/f/2012/347/2/2/batman_derp_o_3_o_by_xxlovelydarkness-d5nyupy.png"
                          alt="user-img" class="img-circle">
                </div>
                <span>
                    {{ auth()->user()->first_name.' '.auth()->user()->last_name }}
                    {{--<span class="caret"></span>--}}
                </span>
                {{--<ul class="dropdown-menu animated flipInY">--}}
                    {{--<li><a href="#"><i class="ti-user"></i> My Profile</a></li>--}}
                    {{--<li><a href="#"><i class="ti-wallet"></i> My Finances</a></li>--}}
                    {{--<li><a href="#"><i class="ti-email"></i> Inbox</a></li>--}}
                    {{--<li role="separator" class="divider"></li>--}}
                    {{--<li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>--}}
                    {{--<li role="separator" class="divider"></li>--}}
                    {{--<li><a href="login.php"><i class="fa fa-power-off"></i> Logout</a></li>--}}
                {{--</ul>--}}
            </div>
        </div>
        <ul class="nav" id="side-menu">
            <li class="nav-small-cap m-t-10">--- Main Menu</li>
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="icon-magic-wand"></i>
                    <span class="hide-menu">
                        Wishes
                        <span class="fa arrow"></span>
                        @if ($reported > 0)
                            <span class="label label-rouded label-red pull-right">{{ $reported }}</span>
                        @endif
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    <li> <a href="/{{ $lang }}/admin/wishes">All Wishes</a> </li>
                    <li> <a href="/{{ $lang }}/admin/wishes/reported">Reported Wishes</a> </li>
                    <li> <a href="/{{ $lang }}/admin/wishes/address">Wishes' Address</a> </li>
                    <li> <a href="/{{ $lang }}/admin/wishes/completed">Completed Wishes</a> </li>
                    <li> <a href="/{{ $lang }}/admin/wishes/settings">Settings</a> </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="icon-people"></i>
                    <span class="hide-menu">
                        Users
                        <span class="fa arrow"></span>
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    <li> <a href="/{{ $lang }}/admin/users">All Users</a> </li>
                    <li> <a href="/{{ $lang }}/admin/users/activity">User Activity</a> </li>
                    <li> <a href="/{{ $lang }}/admin/users/settings">Settings</a> </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="icon-badge"></i>
                    <span class="hide-menu">
                        Achievements
                        <span class="fa arrow"></span>
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    <li> <a href="/{{ $lang }}/admin/achievements">All Achievements</a> </li>
                    <li> <a href="/{{ $lang }}/admin/achievements/prizes">All Prizes</a> </li>
                    <li> <a href="/{{ $lang }}/admin/achievements/new">Create</a> </li>
                    <li> <a href="/{{ $lang }}/admin/achievements/settings">Settings</a> </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="linea-icon linea-basic fa-fw" data-icon="6"></i>
                    <span class="hide-menu">
                        Support
                        <span class="fa arrow"></span>
                        @if ($open > 0)
                            <span class="label label-rouded label-warning pull-right">{{ $open }}</span>
                        @endif
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    <li> <a href="/{{ $lang }}/admin/tickets">All Tickets</a> </li>
                    <li> <a href="/{{ $lang }}/admin/tickets/open">Open Tickets</a> </li>
                    <li> <a href="/{{ $lang }}/admin/tickets/create">Create Ticket</a> </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="icon-wallet"></i>
                    <span class="hide-menu">
                        Payments
                        <span class="fa arrow"></span>
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    <li> <a href="/{{ $lang }}/admin/payments">All Payments</a> </li>
                    <li> <a href="/{{ $lang }}/admin/payments/failed">Failed Payments</a> </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="linea-icon linea-basic fa-fw" data-icon="Y"></i>
                    <span class="hide-menu">
                        Settings
                        <span class="fa arrow"></span>
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    <li> <a href="/{{ $lang }}/admin/settings">General</a> </li>
                    <li> <a href="/{{ $lang }}/admin/payment">Payment</a> </li>
                </ul>
            </li>
            <li>
                <a href="/admin/logout"
                   class="waves-effect"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="icon-logout fa-fw"></i> <span class="hide-menu">Log out</span>
                </a>

                <form id="logout-form" action="/{{ $lang }}/admin/logout" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</div>
<!-- Left navbar-header end -->