<register inline-template>
    <div class="form mw" id="signup">
        <h1>Зарегестрироваться</h1>
        <form class="mw vertical center" method="POST" action="{{ route('register') }}" data-parsley-validate>
            {{ csrf_field() }}
            @if (isset($ref))
                <input type="hidden" name="ref" value="{{ $ref ?? '' }}">
            @endif
            <div class="top-row flex start mw">
                <div class="pos-r w45">
                    <animated name="first_name" id="firstname" trigger="change" type="text">Имя</animated>
                </div>
                <div class="pos-r w45">
                    <animated name="last_name" id="lastname" trigger="change" type="text">Фамилия</animated>
                </div>
            </div>
            <div class="mw">
                <div class="pos-r mw">
                    <animated name="email" id="email" trigger="change" type="email">Email</animated>
                </div>
                <div class="pos-r mw">
                    <animated name="password" minlength="8" id="pass" trigger="change" type="password">Пароль</animated>
                </div>
                <div class="pos-r mw">
                    <animated name="password_confirmation" id="passcheck" trigger="change" equalto="#pass" type="password">Подтвердите пароль</animated>
                </div>
            </div>
            <div class="mw pos-r">
                <label class="terms flex start-center checkbox">
                    <input type="checkbox" name="terms" required> <span class="flex center">Принять <a class="no-select" target="_blank" href="/{{ $lang }}/terms">eсловия использования</a></span>
                </label>
            </div>
            <div class="flex vertical center mw">
                <button class="mw" type="submit">
                    <span class="mw t-align">Продолжить</span>
                </button>
            </div>
        </form>
    </div>
</register>