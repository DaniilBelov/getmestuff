<table border="0" cellpadding="0" cellspacing="0" style="margin:0px; background: #f8f8f8; width: 100%;">
    <tbody>
    <tr>
        <td>
            <div style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                <div style="max-width: 700px; padding:40px 0;  margin: 0px auto; font-size: 14px">
                    <div style="padding: 20px; background: #F16876; margin-bottom: 10px;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/') }}">
                                            <img style="width: 150px; height: auto;" src="{{ $message->embed(asset('/images/logo-white2.png')) }}">
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="padding: 40px; background: #fff;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody style="color: #555;">
                                @yield('content')
                            </tbody>
                        </table>
                    </div>
                    <div style="padding: 20px; background: #fff; margin-top: 10px;border: 1px solid #ccc;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="font-size: 11px; color: #666;" align="center">
                                        <p style="margin: 0 0 5px;">
                                            <a style="color: #666; text-decoration: none;" href="{{ url('terms') }}">Terms and Conditions</a> · 
                                            <a style="color: #666; text-decoration: none;" href="{{ url('privacy') }}">Privacy Policy</a> · 
                                            <a style="color: #666; text-decoration: none;" href="{{ url('faq') }}">FAQ</a>
                                        </p>
                                        <p style="margin: 0;">Copyright 2017 GetMeStuff. All Rights Reserved.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>