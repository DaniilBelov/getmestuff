@extends ('layouts.app')


@if ($lang == 'en')
    @section ('title', ' | Wishes')
@else
    @section ('title', ' | Желания')
@endif

@section ('html-class', 'user-bg overflow-visible current-wishes')

@section ('body-class', 'overflow-visible')

@section ('content')
    <main class="col-12 mw m-auto main-fix">
        <user-info :user="{{ auth()->user() }}"></user-info>

        <wishes :data="{{ $wishes }}">
            <div class="container"></div>
            <div class="container"></div>
            <div class="container"></div>
        </wishes>
    </main>
@endsection