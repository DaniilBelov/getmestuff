@extends('email.en.layout')

@section('content')
    <tr>
        <td>
            <b>Hello {{ $user->first_name.' '.$user->last_name }},</b>
            <p>This is to inform you that, Your account with GetMeStuff has been created successfully.</p>
            <p>Only step left to do is to verify your email.</p>
            <a href="{{ url("register/confirm/{$user->token}") }}" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #F16876; text-decoration:none;"> Verify Email </a>
            <p><b>- Enjoy, GetMeStuff Team</b></p>
        </td>
    </tr>
    <tr>
        <td  style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">
            <p>If you have trouble clicking the button, copy the following address into your browser.</p>
            <a href="{{ url("register/confirm/{$user->token}") }}">{{ url("register/confirm/{$user->token}") }}</a>
        </td>
    </tr>
@endsection