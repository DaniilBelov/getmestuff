@extends('email.en.layout')

@section('content')
    <tr>
        <td style="padding:10px 0 30px 0;">
            <b>Welcome, {{ $user->first_name.' '.$user->last_name }},</b>
            <p>This is to inform you that, Your account with GetMeStuff has been created successfully.</p>
            <p>Only step left to do is to verify your email.</p>
        </td>
    </tr>
    @component('email.components.button', ['url' => url("register/confirm/{$user->token}")])
        Подвтердить email
    @endcomponent
    <tr>
        <td>
            <p><b>Regards, GetMeStuff Team</b></p>
        </td>
    </tr>
    @component('email.components.problem', ['url' => url("register/confirm/{$user->token}")])
        If you have trouble clicking the button, try copying link into your browser.
    @endcomponent
@endsection