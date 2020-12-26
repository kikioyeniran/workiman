
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
                        {{-- @if (Route::currentRouteName() == "contests.show")
                            <input type="hidden" name="redirect_contest_id" value="{{ $contest->id }}">
                        @endif --}}
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
                    <div class="social-login-separator d-none"><span>or</span></div>
                    <div class="social-login-buttons d-none">
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
                    <div class="social-login-separator d-none"><span>or</span></div>
                    <div class="social-login-buttons d-none">
                        <button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
                        <button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
