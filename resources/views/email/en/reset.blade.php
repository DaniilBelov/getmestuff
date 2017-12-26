@extends('email.en.layout')

@section('content')
    <tr>
        <td>
            <p style="margin-top:0px;"><b>Here are your password reset instructions.</b></p>
        </td>
    </tr>
    <tr>
        <td style="padding:10px 0 30px 0;">
            <p>A request to reset your GetMeStuff password has been made.</p>
            <p>If you did not make this request, simply ignore this email.</p>
            <p>If you did make this request, please reset your password:</p>
        </td>
    </tr>
    @component('email.components.button', ['url' => $url])
        Change Password
    @endcomponent
    <tr>
        <td>
            <p><b>Thanks, GetMeStuff Team</b></p>
        </td>
    </tr>
    @component('email.components.problem', ['url' => $url])
        If you have trouble clicking the button, try copying link into your browser.
    @endcomponent
@endsection