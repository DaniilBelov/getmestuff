@extends('admin.layouts.admin')

@section('title', 'Login')

@section('login')
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box login-sidebar">
            <div class="white-box">
                <form class="form-horizontal form-material" id="loginform" method="POST" action="/{{ $lang }}/admin/login">
                    {{ csrf_field() }}
                    <a href="javascript:void(0)" class="text-center db"><img src="{{ asset('admin/plugins/images/eliteadmin-logo-dark.png') }}" alt="Home" /><br/><img src="{{ asset('admin/plugins/images/eliteadmin-text-dark.png') }}" alt="Home" /></a>

                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input name="email" class="form-control" type="text" placeholder="Email Address" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input name="password" class="form-control" type="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox" name="remember" checked>
                                <label for="checkbox-signup"> Remember me </label>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" id="recoverform" method="POST" action="/admin/password/email">
                    {{ csrf_field() }}
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection