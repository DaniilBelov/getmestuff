@extends('email.ru.layout')

@section('content')
    <tr>
        <td style="padding:10px 0 30px 0;">
            <b>Здравствуйте, {{ $user->first_name.' '.$user->last_name }},</b>
            <p>Пожалуйста подтвердите данный email, для того, что бы изменения сохранились.</p>
        </td>
    </tr>
    @component('email.components.button', ['url' => url("home/confirm/{$token}")])
        Поменять email
    @endcomponent
    <tr>
        <td>
            <p>Если вы не меняли ваш email, пожалуйста войдите в вашу учетную запись и поменяйте пароль.</p>
            <p><b>С уважением, команда GetMeStuff</b></p>
        </td>
    </tr>
    @component('email.components.problem', ['url' => url("home/confirm/{$token}")])
        Если у вас возникли проблемы с кнопкой выше, пожалуйста скопируйте ссылку в ваш браузер.
    @endcomponent
@endsection