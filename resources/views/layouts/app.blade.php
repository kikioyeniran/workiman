<!doctype html>
<html lang="en">
    <head>
        <title>{{ config('app.name') }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="{{ asset('logo/logo-icon.png') }}" type="image/jpeg">
        <link rel="stylesheet" href="{{ asset('_home/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('_home/css/colors/wexir-gold.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" />

        @yield('page_styles')
    </head>
<body>

<!-- Wrapper -->
<div id="wrapper">

    @include('layouts.header')

    <div class="clearfix"></div>

    <div class="page-content">
        @yield('page_content')
    </div>

    @include('layouts.footer')

</div>
<!-- Wrapper / End -->


<div id="account-login-popup" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li id="account-login-popup-tabs-login">
                <a href="#login">Login</a>
            </li>
            <li id="account-login-popup-tabs-register">
                <a href="#register">Register</a>
            </li>
        </ul>

        <div class="popup-tabs-container">
            <div class="popup-tab-content" id="login">
                <div class="welcome-text">
                    <h3>We're glad to see you again</h3>
                    <div>
                        Don't have an account? <a href="javascript:void()" class="open-register-tab">Sign Up</a>
                    </div>
                </div>
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-account-circle"></i>
                        <input type="text" class="input-text with-border" name="username" value="{{ old('username') }}" id="username" placeholder="Username" required/>
                    </div>
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-lock"></i>
                        <input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
                    </div>
                    <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit">Login <i class="icon-material-outline-arrow-right-alt"></i></button>
                </form>

				<!-- Social Login -->
				<div class="social-login-separator"><span>or</span></div>
				<div class="social-login-buttons">
					<button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
					<button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>
				</div>
            </div>

            <div class="popup-tab-content" id="register">
                <div class="welcome-text">
                    <h3>Create an account</h3>
                </div>
                <form method="post" action="{{ route('register') }}">
                    @csrf

                    <div class="account-type">
                        <div>
                            <input type="radio" name="account_type_radio" id="employer-radio" value="employer" class="account-type-radio" checked required/>
                            <label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> I want to hire</label>
                        </div>
                        <div>
                            <input type="radio" name="account_type_radio" id="freelancer-radio" value="freelancer" class="account-type-radio" required/>
                            <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Freelancer</label>
                        </div>
                    </div>

                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-account-circle"></i>
                        <input type="text" class="input-text with-border" name="username" value="{{ old('username') }}" id="username" placeholder="Choose a Username" required/>
                    </div>
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-account-circle"></i>
                        <input type="email" class="input-text with-border" name="email" value="{{ old('email') }}" id="email" placeholder="Email Address" required/>
                    </div>
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-lock"></i>
                        <input type="password" class="input-text with-border" name="password" id="password" placeholder="Desired Password" required/>
                    </div>
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-lock"></i>
                        <input type="password" class="input-text with-border" name="password_confirmation" id="password_confirmation" placeholder="Repeat Password" required/>
                    </div>
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit">Create Account <i class="icon-material-outline-arrow-right-alt"></i></button>
                </form>

				<!-- Social Login -->
				<div class="social-login-separator"><span>or</span></div>
				<div class="social-login-buttons">
					<button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
					<button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>
				</div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts
================================================== -->
<script src="{{ asset('_home/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('_home/js/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('_home/js/mmenu.min.html') }}"></script>
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

@yield('page_scripts')

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

    @if($errors->count())
        Snackbar.show({
            text: "{{ $errors->first() }}",
            pos: 'top-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 5000,
            textColor: '#fff',
            backgroundColor: '#721c24'
        });
    @endif
    @if(Session::has('danger'))
        Snackbar.show({
            text: "{!! Session::get('danger') !!}",
            pos: 'top-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 5000,
            textColor: '#fff',
            backgroundColor: '#721c24'
        });
    @endif
    @if(Session::has('success'))
        Snackbar.show({
            text: "{!! Session::get('success') !!}",
            pos: 'top-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 5000,
            textColor: '#fff',
            backgroundColor: '#155724'
        });
    @endif
    @if(Session::has('info'))
        Snackbar.show({
            text: "{!! Session::get('info') !!}",
            pos: 'top-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 5000,
            textColor: '#fff',
            backgroundColor: '#0c5460'
        });
    @endif

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

</body>

</html>
