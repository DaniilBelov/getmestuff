<!doctype html>
<html class="construction" lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="locale" content="{{ app()->getLocale() }}">

        <link href="{{ asset('css/main.css') }}" rel="stylesheet">

        <title>{{ config('app.name') }} @yield('title')</title>
    </head>

    <body class="overflow-visible">
        <div id="app">
            <main class="main flex center vertical">
                @yield ('content')
                <div class="flex start">
                    <a class="btn" href="/{{ $lang }}">Home</a>
                    <a class="btn" id="back">Back</a>
                </div>
            </main>
            <flash :message="{{ json_encode([session('message')]) }}"></flash>
        </div>

        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script>
            Vue.i18n.set('{!! app()->getLocale() !!}');

            $('#back').click(function() {
                console.log(document.referrer);
                window.history.back();
            });
        </script>
    </body>
</html>
