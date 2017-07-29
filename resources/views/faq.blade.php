@extends ('layouts.app')

@if ($lang == 'en')
    @section ('title', ' | FAQ')
@else
    @section ('title', ' | Вопрос - Ответ')
@endif

@section ('html-class', 'overflow-visible user-bg terms')

@section ('body-class', 'overflow-visible')

@section ('content')
    <main class="col-12 mw mh m-auto main-fix flex center">
        <div class="bg-white w8 main-content">
            @include("content.$lang.faq.document")
        </div>
    </main>
@endsection