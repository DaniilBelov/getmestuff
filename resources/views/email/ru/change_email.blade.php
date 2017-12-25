@extends('email.ru.layout')

@section('content')
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
@endsection