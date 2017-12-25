@extends('email.en.layout')

@section('content')
    <tr>
        <td>
            <b>Hello {{ $user->first_name.' '.$user->last_name }},</b>
            <p>Please verify your email, in order for change to persist.</p>
            <a href="{{ url("home/confirm/{$token}") }}" style="display: block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #F16876; text-decoration:none;"> Verify Email </a>
            <p>If you haven't changed your email, please login to GetMeStuff and change your password.</p>
            <a href="{{ url('/login') }}">Login</a>
            <p><b>- Thanks, GetMeStuff Team</b></p>
        </td>
    </tr>
    <tr>
        <td  style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">
            <p>If you have trouble clicking the button, copy the following address into your browser.</p>
            <a href="{{ url("home/confirm/{$token}") }}">{{ url("home/confirm/{$token}") }}</a>
        </td>
    </tr>
@endsection