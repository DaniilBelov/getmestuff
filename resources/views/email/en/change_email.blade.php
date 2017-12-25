@extends('email.en.layout')

@section('content')
    <tr>
        <td style="padding:10px 0 30px 0;">
            <b>Hello, {{ $user->first_name.' '.$user->last_name }},</b>
            <p>Please verify your email, in order for change to persist.</p>
        </td>
    </tr>
    @component('email.components.button', ['url' => url("home/confirm/{$token}")])
        Verify Email
    @endcomponent
    <tr>
        <td>
            <p>If you haven't changed your email, please login to GetMeStuff and change your password.</p>
            <p><b>Regards, GetMeStuff Team</b></p>
        </td>
    </tr>
    @component('email.components.problem', ['url' => url("home/confirm/{$token}")])
        If you have trouble clicking the button, try copying link into your browser.
    @endcomponent
@endsection