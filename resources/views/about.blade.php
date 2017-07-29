@extends ('layouts.app')

@if ($lang == 'en')
    @section ('title', ' | About')
@else
    @section ('title', ' | О нас')
@endif

@section ('html-class', 'about')

@section ('body-class', 'overflow-scroll')

@section ('content')
    <main class="mh mw pos-r">
        <div class="slides">
            <section data-0="top: 0%" class="mw mh pos-a" style="z-index: 10">
                <div class="mw pos-r m-auto fixed-fix inner">
                    @include("content.$lang.about.slide_1")
                </div>
            </section>
            <section data-1000="top: 100%" data-1200="top: 0%" class="mw mh pos-a" style="z-index: 20">
                <div class="mw pos-r m-auto fixed-fix inner">
                    @include("content.$lang.about.slide_2")
                </div>
            </section>
            <section data-2000="top: 100%" data-2200="top: 0%" class="mw mh pos-a" style="z-index: 30">
                <div class="mw pos-r m-auto fixed-fix inner">
                    @include("content.$lang.about.slide_3")
                </div>
            </section>
        </div>
    </main>
@endsection

@section ('script')
    <script type="text/javascript" src="{{ asset('js/skrollr.js') }}"></script>
    <script type="text/javascript">
        var s = skrollr.init();
        var width = $(window).width();
        if (width <= 1030) {
            s.destroy();
        }
        $(window).on('resize', function() {
            if ($(this).width() <= 1030) {
                s.destroy();
            } else {
                skrollr.init();
            }
        });
    </script>
@endsection
