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
                <h1>GetMeStuff</h1>
                @include("content.$lang.construction.message")
            </main>
            <flash :message="{{ json_encode([session('message')]) }}"></flash>
        </div>

        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script>
            Vue.i18n.set('{!! app()->getLocale() !!}');
        </script>
    </body>
</html>
