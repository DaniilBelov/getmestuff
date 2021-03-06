@extends ('layouts.app')

@if ($lang == 'en')
    @section ('title', ' - Best Crowdfunding Website')
@else
    @section ('title', ' - Лучший сайт для помощи')
@endif

@section('seo')

@endsection

@section ('body-class', 'index')

@section ('content')
    <span itemprop="name" style="display: none">GetMeStuff</span>
    <main class="main" id="pp">
        <section class="section main pos-a" style="z-index: 5">
            <div class="main main-section">
                @include("content.$lang.index.main_carousel")
            </div>
        </section>
        <section class="section main">
            <div class="col-12 mw mh flex between m-auto s-section">
                <img itemprop="image" alt="Truck Delivering wishes" src="{{ asset('images/index/how.png') }}">
                @include("content.$lang.index.how")
            </div>
        </section>
        <section class="section main">
            <div class="col-12 mw mh flex between m-auto s-section">
                @include("content.$lang.index.who")
                <img itemprop="image" alt="Drawn Image of Founder" src="{{ asset('images/index/who.png') }}">
            </div>
        </section>
        <section class="section main">
            <div class="col-12 mw mh m-auto s-section center pos-r stories">
                @include("content.$lang.index.success")
            </div>
        </section>
        <section class="section main">
            <div class="col-12 mw mh flex vertical center m-auto s-section">
                @include("content.$lang.index.contact")
            </div>
        </section>
    </main>
 @endsection

@section ('script')
    @include("content.$lang.index.script")
    <script type="text/javascript">
        $(function() {
            $('.owl-carousel').owlCarousel({
                loop: true,
                items: 1,
                autoplay: true,
                autoplayHoverPause: true,
                mouseDrag: false,
                touchDrag: false,
                pullDrag: false,
                dots: false
            });

            // function initOwl() {
            //     $('.stories-wrapper').addClass('owl-carousel owl-theme');
            //     $('.stories-wrapper .t-align').addClass('item');
            //     $('.stories-wrapper').owlCarousel({
            //         loop: true,
            //         items: 1,
            //         autoplay: true,
            //         autoplayHoverPause: true,
            //         mouseDrag: false,
            //         touchDrag: false,
            //         pullDrag: false
            //     });
            // }

            // var width = $(window).width();
            // if (width <= 770) {
            //     initOwl();
            // }

            // $(window).on('resize', function() {
            //     var win = $(this);
            //     if (win.width() <= 770) {
            //         initOwl();
            //     } else {
            //         $('.stories-wrapper').removeClass('owl-carousel owl-theme');
            //         $('.stories-wrapper .t-align').removeClass('item');
            //         $('.stories-wrapper').trigger('destroy.owl.carousel');
            //     }
            // });
        });
    </script>
@endsection