<h1>Password Reset</h1>
<form class="mw vertical center" method="POST" action="{{ route('password.reset.post') }}" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="email" id="email" name="email" placeholder="Email Address" required autofocus>
    <input type="password" id="password" name="password" placeholder="New Password" required>
    <input type="password" id="password_confirm" name="password_confirmation" placeholder="Confirm New Password" required>
    <button class="mw" type="submit">Reset Password</button>
</form>