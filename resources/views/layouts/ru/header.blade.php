<website-header inline-template>
    <header class="around mw">
        <div class="col-12 mh flex between mw header">
            @if(request()->path() == app()->getLocale())
                <img class="logo" src="{{ asset('images/logo-white.png') }}">
            @else
                <img class="logo" src="{{ asset('images/logo-black.png') }}">
            @endif
            <p @click="toggle()" :class="{ active : show }" class="mobile"><i class="fa fa-bars" aria-hidden="true"></i></p>
            <nav :class="{ showNav : show }" class="mw">
                <ul class="mw between">
                    @guest
                        <li><a class="link" href="/{{ $lang }}">Главная</a></li>
                        <li><a class="link" href="/{{ $lang }}/about">О нас</a></li>
                        <li><a class="link" href="/{{ $lang }}/login">Войти</a></li>
                        <li><a class="link" href="/{{ $lang }}/register">Зарегестрироваться</a></li>
                        <li><a href="/lang/en" class="{{ ($lang == 'en') ? 'active' : '' }}">EN</a> | <a href="/lang/ru" class="{{ ($lang == 'ru') ? 'active' : '' }}">РУ</a></li>
                    @else
                        <li><a class="link" href="/{{ $lang }}/home">Профиль</a></li>
                        <li><a class="link" href="/{{ $lang }}/wishes">Желания</a></li>
                        @if (auth()->user()->isAdmin())
                            <li><a class="link" target="_blank" href="/admin/dashboard">Панель</a></li>
                        @endif
                        <li><a class="link" href="/{{ $lang }}/contact">Контакты</a></li>
                        <li class="notification-link pos-r flex start">
                            <a class="link" href="/{{ $lang }}/notifications">Уведомления</a>
                            <div class="unread flex center" v-if="unreadNotifications">
                                <span v-text="unreadCount"></span>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               class="link"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                Выйти
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