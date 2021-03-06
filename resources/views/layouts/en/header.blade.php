<website-header inline-template>
    <header class="around mw">
        <div class="col-12 mh flex between mw header">
            <a href="{{ url("/") }}">
                @if(request()->path() == app()->getLocale() || request()->segment(2) == 'about')
                    <img itemprop="image" alt="GetMeStuff Logo" class="logo" src="{{ asset('images/logo-white2.png') }}">
                    <img style="display: none" itemprop="logo" alt="GetMeStuff Logo" class="logo" src="{{ asset('images/sign.png') }}">
                @else
                    <img itemprop="logo" alt="GetMeStuff Logo" class="logo" src="{{ asset('images/sign.png') }}">
                @endif
            </a>
            <p @click="toggle()" :class="{ active : show }" class="mobile"><i class="fa fa-bars" aria-hidden="true"></i></p>
            <nav :class="{ showNav : show }" class="mw">
                <ul class="mw between">
                    @guest
                        <li><a itemprop="url" class="link" href="/{{ $lang }}">Home</a></li>
                        <li><a itemprop="url" class="link" href="/{{ $lang }}/about">About Us</a></li>
                        <li><a itemprop="url" class="link" href="/{{ $lang }}/login">Log In</a></li>
                        <li><a itemprop="url" class="link" href="/{{ $lang }}/register">Sign Up</a></li>
                        <li><a itemprop="url" href="/lang/en" class="{{ ($lang == 'en') ? 'active' : '' }}">EN</a> | <a href="/lang/ru" class="{{ ($lang == 'ru') ? 'active' : '' }}">РУ</a></li>
                    @else
                        <li><a class="link" href="/{{ $lang }}/home">Home</a></li>
                        <li><a class="link" href="/{{ $lang }}/wishes">Wishes</a></li>
                        @if (auth()->user()->isAdmin())
                            <li><a class="link" target="_blank" href="/admin/dashboard">Dashboard</a></li>
                        @endif
                        <li><a class="link" href="/{{ $lang }}/contact">Contact</a></li>
                        <li class="notification-link pos-r flex start">
                            <a class="link" href="/{{ $lang }}/notifications">Notifications</a>
                            <div class="unread flex center" v-if="unreadNotifications">
                                <span v-text="unreadCount"></span>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               class="link"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                Log Out
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>
</website-header>