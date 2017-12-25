@extends('email.en.layout')

@section('content')
    <tr>
        <td style="border-bottom:1px solid #f6f6f6;">
            <p style="margin-top:0px; color:#bbbbbb;">Here are your password reset instructions.</p>
        </td>
    </tr>
    <tr>
        <td style="padding:10px 0 30px 0;">
            <p>A request to reset your GetMeStuff password has been made.</p>
            <p>If you did not make this request, simply ignore this email.</p>
            <p>If you did make this request, please reset your password:</p>
            <a href="{{ $url }}" style="display: inline-block; padding: 11px 30px; margin: 20px auto 30px; font-size: 15px; color: #fff; background: #F16876; text-decoration:none;">Reset Password</a>
            <p><b>- Thanks, GetMeStuff Team</b></p>
        </td>
    </tr>
    <tr>
        <td  style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">
            <p>If you have trouble clicking the button, try copying link into your browser.</p>
            <p>If you still have problems, feel free to contact us.</p>
        </td>
    </tr>
@endsection