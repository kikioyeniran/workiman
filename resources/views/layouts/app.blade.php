<!doctype html>
<html lang="en">
    <head>
        <title>{{ config('app.name') }} | @yield("page_title", "Welcome")</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="{{ asset('logo/logo-icon.png') }}" type="image/jpeg">
        <link rel="stylesheet" href="{{ asset('_home/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('_home/css/colors/wexir-gold.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset("vendor/dropzone/dropzone.css") }}">

        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" />

        @yield('page_styles')
    </head>
<body>

    <div id="loading">
        <img src="{{ asset('logo/logo.png') }}" alt="" height="100">
    </div>
<!-- Wrapper -->
<div id="wrapper">

    @include('layouts.header')

    {{-- <div class="clearfix"></div> --}}

    <div class="page-content" style="min-height: 70vh;">
        @yield('page_content')
    </div>

    @include('layouts.footer')

</div>
<!-- Wrapper / End -->

@include('layouts.account_login_popup')

<!-- Scripts
================================================== -->
<script src="{{ asset('_home/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('_home/js/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('_home/js/mmenu.min.js') }}"></script>
<script src="{{ asset('_home/js/tippy.all.min.js') }}"></script>
<script src="{{ asset('_home/js/simplebar.min.js') }}"></script>
<script src="{{ asset('_home/js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('_home/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('_home/js/snackbar.js') }}"></script>
<script src="{{ asset('_home/js/clipboard.min.js') }}"></script>
<script src="{{ asset('_home/js/counterup.min.js') }}"></script>
<script src="{{ asset('_home/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('_home/js/slick.min.js') }}"></script>
<script src="{{ asset('_home/js/custom.js') }}"></script>

<script src="{{ asset('js/custom.js') }}"></script>

<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

<script type="text/javascript">
    const webRoot = "{{ route('index') }}/"
    const _token = "{{ csrf_token() }}"
</script>

@yield('page_scripts')

@include('layouts.snackbar_alerts')

<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
    // Snackbar for user status switcher
    $('#snackbar-user-status label').click(function() {
        Snackbar.show({
            text: 'Your status has been changed!',
            pos: 'top-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 5000,
            textColor: '#fff',
            backgroundColor: '#721c24'
        });
    });

    @if(Session::has('register'))
        $(document).ready(() => {
            $('a#account-login-popup-trigger').trigger('click')
            $(".popup-tab-content").hide();
            $("#register.popup-tab-content").show();
            $("#account-login-popup-tabs-register").addClass('active')
            $("#account-login-popup-tabs-login").removeClass('active')
        })
    @elseif(Session::has('login'))
        $(document).ready(() => {
            $('a#account-login-popup-trigger').trigger('click')
            $(".popup-tab-content").hide();
            $("#login.popup-tab-content").show();
            $("#account-login-popup-tabs-login").addClass('active')
            $("#account-login-popup-tabs-register").removeClass('active')
        })
    @endif

</script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->

    <script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyAfsElRXO9jIquc55wPrEOrZ7LRooXORJw",
        authDomain: "wexir-25f98.firebaseapp.com",
        projectId: "wexir-25f98",
        storageBucket: "wexir-25f98.appspot.com",
        messagingSenderId: "953308554512",
        appId: "1:953308554512:web:23dcebbe5e1010e9beb195"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    </script>

</body>

</html>
