@extends('admin.layouts.admin')

@section('title', 'Login')

@section('login')
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box login-sidebar">
            <div class="white-box">
                <form class="form-horizontal" id="resetform" method="POST" action="/admin/password/reset">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Reset Password</h3>
                            <p class="text-muted">Change Your Password</p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required autofocus>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input type="password" class="form-control" name="password" placeholder="New Password" required>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password" required>
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