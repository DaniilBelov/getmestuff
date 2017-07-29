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
                                <td>
                                    <b>Здравствуйте, {{ $user->first_name.' '.$user->last_name }},</b>
                                    <p>Пожалуйста подтвердите данный email, для того, что бы изменения сохранились.</p>
                                    <a href="{{ url("home/confirm/{$token}") }}" target="_blank" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #F16876; text-decoration:none;"> Подвтердить Email </a>
                                    <p>Если вы не меняли ваш email, пожалуйста войдите в вашу учетную запись и поменяйте пароль.</p>
                                    <p><a href="{{ url('/login') }}">Войти</a></p>
                                    <p><b>- С уважением, команда GetMeStuff</b></p>
                                </td>
                            </tr>
                            <tr>
                                <td  style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">
                                    <p>Если у вас возникли проблемы с кнопкой выше, пожалуйста скопируйте ссылку нижу в ваш браузер.</p>
                                    <a target="_blank" href="{{ url("home/confirm/{$token}") }}">{{ url("home/confirm/{$token}") }}</a>
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