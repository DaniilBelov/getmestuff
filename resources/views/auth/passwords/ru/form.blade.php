<h1>Восстановить пароль</h1>
<form class="mw vertical center" method="POST" action="{{ route('password.reset.post') }}" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="email" id="email" name="email" placeholder="Email" required autofocus>
    <input type="password" id="password" name="password" placeholder="Новый пароль" required>
    <input type="password" id="password_confirm" name="password_confirmation" placeholder="Подтвердите новый пароль" required>
    <button class="mw" type="submit">Восстановить пароль</button>
</form>