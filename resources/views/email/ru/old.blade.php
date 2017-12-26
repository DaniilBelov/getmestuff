@extends('email.ru.layout')

@section('content')
    <tr>
        <td>
            <b>Здравствуйте {{ $wish->user->first_name.' '.$wish->user->last_name }},</b>
            <p>Ваше желание для <b>{{ $wish->translate('en')->item }}</b> уже активно месяц.</p>
            <p>Мы поменяли его приоритет на <b>{{ $priority }}%</b>.</p>
            <p>Вы можете подождать его завершения или написать нам для переноса денег на другой продукт.</p>
            <p><b>- С уважением, команда GetMeStuff</b></p>
        </td>
    </tr>
@endsection