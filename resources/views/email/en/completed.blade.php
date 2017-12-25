@extends('email.en.layout')

@section('content')
    <tr>
        <td>
            <b>Hello {{ $wish->user->first_name.' '.$wish->user->last_name }},</b>
            <p>Your wish for <b>{{ $wish->translate('en')->item }}</b> has been completed.</p>
            <p>It will be delivered to the following address:</p>
            <address style="padding-left: 1em"> 
                {{ $wish->address['address_one'] }}<br>
                @if($wish->address['address_two'] != '')
                    {{ $wish->address['address_two'] }}<br>
                @endif
                {{ $wish->address['city'] }}<br>
                {{ $wish->address['post_code'] }}<br>
                {{ $wish->address['country'] }}<br>
            </address>
            <p>If this is wrong, please contact us.</p>
            <p><b>- Thanks, GetMeStuff Team</b></p>
        </td>
    </tr>
@endsection