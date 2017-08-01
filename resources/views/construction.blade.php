<!doctype html>
<html class="construction" lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="locale" content="{{ app()->getLocale() }}">

        <link href="{{ asset('css/main.css') }}" rel="stylesheet">

        @if ($lang == 'en')
            <title>{{ config('app.name') }} | Construction</title>
        @else
            <title>{{ config('app.name') }} | Скоро вернемся</title>
        @endif
    </head>

    <body class="overflow-visible">
        <div id="app">
            <main class="main flex center vertical">
                <div class="construction-logo m-auto">
                    <img class="mw" src="{{ asset('images/logo-white2.png') }}" alt="GetMeStuff">
                </div>
                @if ($lang == 'ru')
                    <p class="w8 t-align">
                        Здравствуйте, в данный момент мы дорабатываем сайт. Скоро будем с Вами.
                    </p>
                @else
                    <p class="w8 t-align">
                        Hello, we are currently finishing up. We will be with you shortly.
                    </p>
                @endif
                {{-- @include("content.$lang.construction.message") --}}
            </main>
            <flash :message="{{ json_encode([session('message')]) }}"></flash>
        </div>

        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script>
            Vue.i18n.set('{!! app()->getLocale() !!}');
        </script>
    </body>
</html>
