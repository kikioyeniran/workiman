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
                    {{-- @if (Route::currentRouteName() == 'contests.show')
                            <input type="hidden" name="redirect_contest_id" value="{{ $contest->id }}">
                        @endif --}}
                    @csrf
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-account-circle"></i>
                        <input type="text" class="input-text with-border" name="username"
                            value="{{ old('username') }}" id="username" placeholder="Username" required />
                    </div>
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-lock"></i>
                        <input type="password" class="input-text with-border" name="password" id="password"
                            placeholder="Password" required />
                        <i class="fa icon-feather-eye-off show-password" data-input="login-password"></i>
                    </div>
                    <button class="button margin-top-35 full-width button-sliding-icon ripple-effect"
                        type="submit">Login <i class="icon-material-outline-arrow-right-alt"></i></button>
                </form>

                <!-- Social Login -->
                <div class="social-login-separator"><span>or</span></div>
                <div class="social -login-buttons text-center d-flex justify-content-center">
                    <a href="{{ route('password.request') }}"
                        class="facebook-login ripple-effect "> Forgot Password?</a>
                    {{-- <a href="{{ route('social-login.redirect', ['provider' => 'google']) }}"
                        class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via
                        Google+</a> --}}
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
                            <input type="radio" name="account_type_radio" id="employer-radio" value="employer"
                                class="account-type-radio" checked required />
                            <label for="employer-radio" class="ripple-effect-dark"><i
                                    class="icon-material-outline-business-center"></i> I want to hire</label>
                        </div>
                        <div>
                            <input type="radio" name="account_type_radio" id="freelancer-radio" value="freelancer"
                                class="account-type-radio" required />
                            <label for="freelancer-radio" class="ripple-effect-dark"><i
                                    class="icon-material-outline-account-circle"></i> Freelancer</label>
                        </div>
                    </div>

                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-account-circle"></i>
                        <input type="text" class="input-text with-border" name="username"
                            value="{{ old('username') }}" id="username" placeholder="Choose a Username" required />
                    </div>
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-account-circle"></i>
                        <input type="email" class="input-text with-border" name="email" value="{{ old('email') }}"
                            id="email" placeholder="Email Address" required />
                    </div>
                    <div class="input-with-icon-left mb-4">
                        <i class="icon-material-outline-account-circle"></i>
                        <select name="country" id="" class="selectpickers input-text with-border" style="padding-left: 60px" required>
                            <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" data-calling="{{ $country->calling_code }}"> {{ $country->name }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="input-with-icon-left">
                        {{-- <i class="icon-material-outline-account-circle"></i> --}}
                        <i style="width: 50px">
                            <small style="font-style: normal" id="calling-code">
                                <i class="icon-feather-phone"></i>
                                {{-- @if ($user->country_id)
                                +{{ $user->country->calling_code }} @else <i
                                        class="icon-feather-phone"></i> @endif --}}
                            </small>
                        </i>
                        <input type="tel" class="input-text with-border" name="phone" value="{{ old('phone') }}"
                            id="phone" placeholder="Phone Number" required />
                    </div>

                    {{-- <div class="col-xl-4">
                        <div class="submit-field">
                            <h5>Phone</h5>
                            <div class="input-with-icon-left no-border">
                                <i style="width: 60px">
                                    <small style="font-style: normal" id="calling-code">
                                        @if ($user->country_id)
                                        +{{ $user->country->calling_code }} @else <i
                                                class="icon-feather-phone"></i> @endif
                                    </small>
                                </i>
                                <input type="text" class="input-text" placeholder="" name="phone"
                                    value="{{ $user->phone }}" required>
                            </div>
                        </div>
                    </div> --}}
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-lock"></i>
                        <input type="password" class="input-text with-border" name="password" id="password"
                            placeholder="Desired Password" required />
                        <i class="fa icon-feather-eye-off show-password" data-input="register-password"></i>
                    </div>
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-lock"></i>
                        <input type="password" class="input-text with-border" name="password_confirmation"
                            id="password_confirmation" placeholder="Repeat Password" required />
                        <i class="fa icon-feather-eye-off show-password"
                            data-input="register-password-confirmation"></i>
                    </div>
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit">Create Account <i
                            class="icon-material-outline-arrow-right-alt"></i></button>
                </form>

                <!-- Social Login -->
                {{-- <div class="social-login-separator"><span>or</span></div>
                <div class="social-login-buttons text-center d-flex justify-content-center">
                    <a href="{{ route('social-login.redirect', ['provider' => 'faceboook']) }}"
                        class="facebook-login ripple-effect d-none"><i class="icon-brand-facebook-f"></i> Log In via
                        Facebook</a>
                    <a href="{{ route('social-login.redirect', ['provider' => 'google']) }}"
                        class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via
                        Google+</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>
