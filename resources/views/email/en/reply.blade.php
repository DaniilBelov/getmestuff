<table border="0" cellpadding="0" cellspacing="0" style="margin:0px; background: #f8f8f8; width: 100%;">
    <tbody>
    <tr>
        <td>
            <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
                    <div style="padding: 40px; background: #fff;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody>
                            <tr>
                                <td><b>Hello, {{ $user ? $user->first_name.' '.$user->last_name.',' : '' }}</b>
                                    <p>{!! $body !!}</p>
                                    <b>- Thanks, GetMeStuff Team.</b> </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
                        <p> Powered by {{ config('app.name') }}</p>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>