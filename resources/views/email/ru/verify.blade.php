@extends('email.ru.layout')

@section('content')
    <tr>
        <td style="padding:10px 0 30px 0;">
            <b>Добро пожаловать, {{ $user->first_name.' '.$user->last_name }},</b>
            <p>Ваша учетная занписаь с GetMeStuff была создана успешно.</p>
            <p>Осталось только подтвердить ваш email.</p>
        </td>
    </tr>
    @component('email.components.button', ['url' => url("register/confirm/{$user->token}")])
        Подвтердить email
    @endcomponent
    <tr>
        <td>
            <p><b>С уважением, команда GetMeStuff</b></p>
        </td>
    </tr>
    @component('email.components.problem', ['url' => url("register/confirm/{$user->token}")])
        Если у вас возникли проблемы с кнопкой выше, пожалуйста скопируйте ссылку в ваш браузер.
    @endcomponent
@endsection