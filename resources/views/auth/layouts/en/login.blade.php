<login inline-template>
    <div class="form mw flex vertical center">
        <h1>Welcome Back</h1>
        <form class="vertical center mw" method="POST" action="{{ route('login') }}" id="loginform" data-parsley-validate>
            {{ csrf_field() }}
            <div class="mw">
                <div class="pos-r mw">
                    <animated name="email" id="loginmail" trigger="change" type="email">Email Address</animated>
                </div>
                <div class="pos-r mw">
                    <animated name="password" id="loginpass" trigger="change" type="password">Password</animated>
                </div>
            </div>
            <div class="mw flex between">
                <label class="terms flex start-center checkbox-login checkbox">
                    <input type="checkbox" name="remember" checked> <span class="flex center">Remember me</span>
                </label>
                <div class="forgot">
                    <p class="hover" @click="showForm()">Forgot Password?</p>
                </div>
            </div>
            <button class="mw" type="submit">
                <span class="mw t-align">Log In</span>
            </button>
        </form>
        <forgot-password :visible="visible" v-on:close='visible = false' route="{{ route('password.email') }}"></forgot-password>
    </div>
</login>