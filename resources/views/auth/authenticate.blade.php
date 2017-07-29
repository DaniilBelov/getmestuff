@extends ('layouts.app')

@if ($lang == 'en')
    @section ('title', ' | Authenticate')
@else
    @section ('title', ' | Вход')
@endif

@section ('html-class', 'login overflow-visible')

@section ('body-class', 'overflow-visible')

@section ('content')
    <main class="mh mw">
        <section class="pos-r flex vertical center">
            <tabs form="{{ $form }}">
                <tab name="{{ ($lang == 'en') ? 'Sign Up' : 'Зарег.' }}" form="Sign Up" :transition="false">
                    @include ("auth.layouts.$lang.register")
                </tab>
                <tab name="{{ ($lang == 'en') ? 'Log In' : 'Войти' }}" form="Log In" :transition="false">
                    @include ("auth.layouts.$lang.login")
                </tab>
            </tabs>
        </section>
    </main>
@endsection
