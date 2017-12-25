@extends('email.en.layout')

@section('content')
    <tr>
        <td>
            <b>Hello {{ $wish->user->first_name.' '.$wish->user->last_name }},</b>
            <p>Your wish for <b>{{ $wish->translate('en')->item }}</b> has been active for one month.</p>
            <p>We have increased its priority by <b>{{ $priority }}</b>.</p>
            <p>You can wait until it completes, or you can contact us and transfer the money to a cheaper product.</p>
            <p><b>Regards, GetMeStuff Team</b></p>
        </td>
    </tr>
@endsection