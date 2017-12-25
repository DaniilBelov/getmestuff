@extends('email.ru.layout')

@section('content')
    <tr>
        <td style="border-bottom:1px solid #f6f6f6;">
            <p style="margin-top:0px; color:#bbbbbb;">Поажлуйста следуйте инструкциям что бы поменять пароль.</p>
        </td>
    </tr>
    <tr>
        <td style="padding:10px 0 30px 0;">
            <p>Мы получили запрос о замене пароля.</p>
            <p>Если вы не запрашивали восстановелние пароля, проигнорирйте это сообщение.</p>
            <p>Иначе, поажулйста, поменяйте свой пароль:</p>
            <a href="{{ $url }}" style="display: inline-block; padding: 11px 30px; margin: 20px auto 30px; font-size: 15px; color: #fff; background: #F16876; text-decoration:none;">Пмоенять Пароль</a>
            <p><b>- С уважением, команда GetMeStuff</b></p>
        </td>
    </tr>
    <tr>
        <td  style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">
            <p>Если у вас возникли проблемы с кнопкой выше, пожалуйста скопируйте ссылку в ваш браузер.</p>
        </td>
    </tr>
@endsection