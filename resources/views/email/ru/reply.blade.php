@extends('email.ru.layout')

@section('content')
    <tr>
        <td>
            <b>Здравствуйте, {{ $user ? $user->first_name.' '.$user->last_name.',' : '' }}</b>
            <p>{!! $body !!}</p>
            <b>- С уважением, команда GetMeStuff.</b>
        </td>
    </tr>
@endsection