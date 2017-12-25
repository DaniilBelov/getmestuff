@extends('email.ru.layout')

@section('content')
    <tr>
        <td>
            <b>Здравствуйте {{ $wish->user->first_name.' '.$wish->user->last_name }},</b>
            <p>Ваше желание <b>{{ $wish->translate('ru')->item }}</b> выполненно.</p>
            <p>Оно будет доставленно по следующему адресу:</p>
            <address style="padding-left: 1em"> 
                {{ $wish->address['address_one'] }}<br>
                @if($wish->address['address_two'] != '')
                    {{ $wish->address['address_two'] }}<br>
                @endif
                {{ $wish->address['city'] }}<br>
                {{ $wish->address['post_code'] }}<br>
                {{ $wish->address['country'] }}<br>
            </address>
            <p>Если адрес не верен, пожалуйста свяжитесь с нами.</p>
            <p><b>- С уважением, команда GetMeStuff</b></p>
        </td>
    </tr>
@endsection