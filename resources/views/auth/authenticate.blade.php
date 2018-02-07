@extends ('layouts.app')

@if ($lang == 'en' && request()->segment(2) == 'login')
    @section ('title', ' | Login')
@elseif ($lang == 'en' && request()->segment(2) == 'register')
    @section ('title', ' | Register')
@elseif ($lang == 'ru' && request()->segment(2) == 'login')
    @section ('title', ' | Войти')
@else
    @section ('title', ' | Регистрация')
@endif

@section('seo')

@endsection

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
