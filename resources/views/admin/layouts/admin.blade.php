<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="locale" content="{{ app()->getLocale() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>GMS Admin | @yield('title')</title>

    @include ('admin.layouts.links.style')

    @yield('header')
</head>
<body>
    <div id="app">
        @if (count($errors) > 0)
            <div class="alert alert-danger alert-error-custom alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ((!strpos(request()->path(), 'abc')) && (!strpos(request()->path(), 'password')))

            @include('admin.layouts.blocks.header')
            @include('admin.layouts.blocks.sidebar_left')

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">@yield('page_title')</h4> </div>
                        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                            {{ breadcrumbs() }}
                        </div>
                    </div>
                    @yield('content')
                    @include('admin.layouts.blocks.right-sidebar')
                </div>
                @include('admin.layouts.blocks.footer')
            </div>

        @else
            @yield('login')
        @endif
        <flash :message="{{ json_encode([session('message')]) }}"></flash>
    </div>

    @include('admin.layouts.links.script')
    @yield('scripts')

    <script src="{{ asset('admin/app.js') }}"></script>
</body>

</html>