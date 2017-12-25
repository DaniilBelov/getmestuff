@extends('email.ru.layout')

@section('content')
    <tr>
        <td>
            <p style="margin-top:0px; color:#bbbbbb;"><b>Пожалуйста следуйте инструкциям что бы поменять пароль.</b></p>
        </td>
    </tr>
    <tr>
        <td style="padding:10px 0 30px 0;">
            <p>Мы получили запрос о замене пароля.</p>
            <p>Если вы не запрашивали восстановелние пароля, проигнорирйте это сообщение.</p>
            <p>Иначе, пожалуйста, поменяйте свой пароль:</p>
        </td>
    </tr>
    @component('email.components.button', ['url' => $url])
        Поменять пароль
    @endcomponent
    <tr>
        <td>
            <p><b>С уважением, команда GetMeStuff</b></p>
        </td>
    </tr>
    @component('email.components.problem', ['url' => $url])
        Если у вас возникли проблемы с кнопкой выше, пожалуйста скопируйте ссылку в ваш браузер.
    @endcomponent
@endsection