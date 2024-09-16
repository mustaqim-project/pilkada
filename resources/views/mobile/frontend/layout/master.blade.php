<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <title>Sidaksis</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('mobile/styles/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/fonts/css/fontawesome-all.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
    <link rel="manifest" href="{{ asset('mobile/_manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mobile/images/logobulat.png') }}">
    <link rel="icon" href="{{ asset('mobile/images/logobulat.png') }}" type="image/png">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Flatpickr Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="theme-light" data-highlight="green3">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">
        @include('mobile.components.header')
        @include('mobile.components.footer-bar')


        @yield('content')



        <div id="menu-share" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="420" data-menu-effect="menu-over">
            @include('mobile.frontend.dashboard.menu-share')
        </div>

        <div id="menu-highlights" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="510" data-menu-effect="menu-over">
            @include('mobile.frontend.dashboard.menu-colors')
        </div>

        <div id="menu-main" class="menu menu-box-right menu-box-detached rounded-m" data-menu-width="260" data-menu-active="nav-welcome" data-menu-effect="menu-over">
            @include('mobile.frontend.dashboard.menu-main')
        </div>

        <!-- Be sure this is on your main visiting page, for example, the index page -->
        <!-- Install Prompt for Android -->
        {{-- <div id="menu-install-pwa-android" class="menu menu-box-bottom menu-box-detached rounded-l" data-menu-height="350" data-menu-effect="menu-parallax">
            <div class="boxed-text-l mt-4">
                <img class="rounded-l mb-3" src="{{ asset('mobile/images/logo.png') }}" alt="img" width="90">
                <h4 class="mt-3">Sidaksis on your Home Screen</h4>
                <p>Install Sidaksis on your home screen, and access it just like a regular app. It really is that simple!</p>
                <a href="#" class="pwa-install btn btn-s rounded-s shadow-l text-uppercase font-900 bg-highlight mb-2">Add to Home Screen</a><br>
                <div class="clear"></div>
            </div>
        </div> --}}

        <!-- Install instructions for iOS -->
        {{-- <div id="menu-install-pwa-ios" class="menu menu-box-bottom menu-box-detached rounded-l" data-menu-height="320" data-menu-effect="menu-parallax">
            <div class="boxed-text-xl mt-4">
                <img class="rounded-l mb-3" src="{{ asset('mobile/images/logo.png') }}" alt="img" width="90">
                <h4 class="mt-3">Sidaksis on your Home Screen</h4>
                <p class="mb-0 pb-3">Install Sidaksis on your home screen, and access it just like a regular app. Open your Safari menu and tap "Add to Home Screen".</p>
                <div class="clear"></div>
                <i class="fa-ios-arrow fa fa-caret-down font-40"></i>
            </div>
        </div> --}}
    </div>

    <script type="text/javascript" src="{{ asset('mobile/scripts/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/scripts/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/scripts/custom.js') }}"></script>
</body>
</html>
