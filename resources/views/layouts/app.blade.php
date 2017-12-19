<!doctype html>
<html class="@yield('html-class')" lang="{{ app()->getLocale() }}">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#666666">
        <meta name="theme-color" content="#ffffff">

        <script src="https://vk.com/js/api/openapi.js?146" type="text/javascript"></script>
        <script type="text/javascript" src="https://vk.com/js/api/share.js?93" charset="windows-1251"></script>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

        <script>
            window.App = {!! json_encode([
                'csrfToken' => csrf_token(),
                'user' => Auth::user(),
                'locale' => app()->getLocale(),
                'signedIn' => Auth::check()
            ]) !!}
        </script>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="locale" content="{{ app()->getLocale() }}">

        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        
        <title>{{ config('app.name') }} @yield('title')</title>

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-103016274-1', 'auto');
            ga('send', 'pageview');
        </script>
    </head>
    
    <body class="@yield ('body-class')">
        <div id="fb-root"></div>
        <script>
            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                if (window.App.locale == 'ru') {
                    js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.9&appId=207139529816294";
                } else {
                    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=207139529816294";
                }
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <div id="app">
            @include ("layouts.$lang.header")
            
            @yield ('content')

            @include ("layouts.$lang.footer")

            <flash :message="{{ json_encode([session('message')]) }}"></flash>

            @if (count($errors) > 0)
                <errors :errors="{{ json_encode($errors->all()) }}"></errors>
            @endif
        </div>

        @include('misc.spinner')

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKzTCqlun4x4XHknXnpZV63TVX-dHSemA&libraries=places&language={!! app()->getLocale() !!}"></script>
        {{--  <script src="https://www.paypalobjects.com/api/checkout.js"></script>          --}}
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script>
            window.onload = function () { 
                setTimeout(function () {
                    $('#loader').hide();
                }, 200);
            }
        </script>
        
        @yield ('script')
   
    </body>
</html>
