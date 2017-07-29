@extends ('layouts.app')

@section ('title', ' | Reset')

@section ('html-class', 'overflow-visible user-bg password-reset')

@section ('body-class', 'overflow-visible')

@section ('html-class')

@section ('content')
    <main class="fixed-fix flex center main">
        <div class="w5 flex vertical center bg-white container">
            @include("auth.passwords.$lang.form")
        </div>
    </main>
@endsection