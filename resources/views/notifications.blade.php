@extends ('layouts.app')

@if ($lang == 'en')
    @section ('title', ' | Notifications')
@else
    @section ('title', ' | Оповещения')
@endif

@section ('html-class', 'overflow-visible user-bg notifications')

@section ('body-class', 'overflow-visible')

@section ('content')
    <main class="col-12 mw m-auto main-fix flex vertical center">
        <user-info :user="{{ auth()->user() }}" :notifications="{{ auth()->user()->unreadNotifications }}"></user-info>
        
        <div class="mw flex s-between notifications-wrapper">
            <notifications></notifications>
            <payments></payments>
        </div>
    </main>
@endsection