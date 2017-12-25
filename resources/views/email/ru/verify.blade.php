@extends('email.ru.layout')

@section('content')
    <tr>
        <td>
            <b>Добро пожаловать, {{ $user->first_name.' '.$user->last_name }},</b>
            <p>Ваша учетная занписаь с GetMeStuff была создана успешно.</p>
            <p>Осталось только подтвердить ваш email.</p>
            <a href="{{ url("register/confirm/{$user->token}") }}" target="_blank" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #F16876; text-decoration:none;"> Подвтердить Email </a>
            <p><b>- С уважением, команда GetMeStuff</b></p>
        </td>
    </tr>
    <tr>
        <td style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">
            <p>Если у вас возникли проблемы с кнопкой выше, пожалуйста скопируйте ссылку нижу в ваш браузер.</p>
            <a target="_blank" href="{{ url("register/confirm/{$user->token}") }}">{{ url("register/confirm/{$user->token}") }}</a>
        </td>
    </tr>
@endsection