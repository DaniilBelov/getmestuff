<table border="0" cellpadding="0" cellspacing="0" style="margin:0px; background: #f8f8f8; width: 100%;">
    <tbody>
    <tr>
        <td>
            <div style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
                    <div style="padding: 40px; background: #fff;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <b>Hello {{ $user->first_name.' '.$user->last_name }},</b>
                                    <p>Please verify your email, in order for change to persist.</p>
                                    <a href="{{ url("home/confirm/{$token}") }}" style="display: block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #F16876; text-decoration:none;"> Verify Email </a>
                                    <p>If you haven't changed your email, please login to GetMeStuff and change your password.</p>
                                    <a href="{{ url('/login') }}">Login</a>
                                    <p><b>- Thanks, GetMeStuff Team</b></p>
                                </td>
                            </tr>
                            <tr>
                                <td  style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">
                                    <p>If you have trouble clicking the button, copy the following address into your browser.</p>
                                    <a href="{{ url("home/confirm/{$token}") }}">{{ url("home/confirm/{$token}") }}</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
                        <p> Powered by Themedesigner.in <br>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>