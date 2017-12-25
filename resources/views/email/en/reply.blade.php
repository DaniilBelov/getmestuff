@extends('email.en.layout')

@section('content')
    <tr>
        <td>
            <b>Hello, {{ $user ? $user->first_name.' '.$user->last_name.',' : '' }}</b>
            <p>{!! $body !!}</p>
            <p><b>Regards, GetMeStuff Team</b></p>
        </td>
    </tr>
@endsection