<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
    <meta name="keywords"
        content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>{{ config('title', 'Cosplayer') }} - @yield('title')</title>
    <link rel="apple-touch-icon"
        href="{{ asset('template/assets/app-assets/images/favicon/apple-touch-icon-152x152.png') }}">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ asset('template/assets/app-assets/images/favicon/favicon-32x32.png') }}">
    <link href="{{ asset('template/icon.css?family=Material+Icons') }}" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/app-assets/vendors/vendors.min.css') }}">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('template/assets/app-assets/css/themes/vertical-dark-menu-template/materialize.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('template/assets/app-assets/css/themes/vertical-dark-menu-template/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/app-assets/css/pages/dashboard.min.css') }}">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/app-assets/css/custom/custom.css') }}">
    <!-- END: Custom CSS-->
    @livewireStyles
</head>
<!-- END: Head-->

<body
    class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns "
    data-open="click" data-menu="vertical-dark-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    {{-- @include('layouts.partials.header_close') --}}
    {{-- ini gunalivewire sebab ada logout tu dia xde kat route web yg biasa --}}
    <livewire:layout.backend_header />
    <!-- END: Header-->


    <!-- BEGIN: SideNav-->
    @include('layouts.partials.sidebar')
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    @yield('content')
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    <!-- END: Page Main-->

    <!-- Theme Customizer -->
    @include('layouts.partials.theme')
    <!--/ Theme Customizer -->


    <!-- BEGIN: Footer-->
    <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        <div class="footer-copyright">
            <div class="container"><span>&copy; 2024 <a href="https://nizar-khan.com/"
                        target="_blank">Nizar Khan</a> All rights reserved.</span><span
                    class="right hide-on-small-only">Design and Developed by <a
                        href="https://nizar-khan.com/">Nizar Khan</a></span></div>
        </div>
    </footer>
    <!-- END: Footer-->


    @livewireScripts
    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('template/assets/app-assets/js/vendors.min.js') }}"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{ asset('template/assets/app-assets/vendors/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('template/assets/app-assets/vendors/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="{{ asset('template/assets/app-assets/js/plugins.min.js') }}"></script>
    <script src="{{ asset('template/assets/app-assets/js/search.min.js') }}"></script>
    <script src="{{ asset('template/assets/app-assets/js/custom/custom-script.min.js') }}"></script>
    <script src="{{ asset('template/assets/app-assets/js/scripts/customizer.min.js') }}"></script>
    <!-- END THEME  JS-->
</body>

</html>
