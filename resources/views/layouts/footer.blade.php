<div id="footer" class="">
    <div class="footer-top-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <div class="footer-rows-container">

                        <div class="footer-rows-left">
                            <div class="footer-row">
                                <div class="footer-row-inner footer-logo">
                                    <img src="{{ asset('logo/logo-icon.png') }}" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="footer-rows-right">

                            <div class="footer-row">
                                <div class="footer-row-inner">
                                    <ul class="footer-social-links">
                                        <li>
                                            <a href="#" title="Facebook" data-tippy-placement="bottom" data-tippy-theme="light">
                                                <i class="icon-brand-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Twitter" data-tippy-placement="bottom" data-tippy-theme="light">
                                                <i class="icon-brand-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Google Plus" data-tippy-placement="bottom" data-tippy-theme="light">
                                                <i class="icon-brand-google-plus-g"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="LinkedIn" data-tippy-placement="bottom" data-tippy-theme="light">
                                                <i class="icon-brand-linkedin-in"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="footer-row d-none">
                                <div class="footer-row-inner">
                                    <select class="selectpicker language-switcher" data-selected-text-format="count" data-size="5">
                                        <option selected>English</option>
                                        <option>Français</option>
                                        <option>Español</option>
                                        <option>Deutsch</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-middle-section">
        <div class="container">
            <div class="row">

                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-links">
                        <h3>For Freelancers</h3>
                        <ul>
                            <li><a href="{{ route("contests.index") }}"><span>Browse Contests</span></a></li>
                            <li><a href="{{ route("offers.project-managers.index") }}"><span>Browse Offers</span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-links">
                        <h3>For Employers</h3>
                        <ul>
                            <li><a href="{{ route("offers.freelancers.index") }}"><span>Browse Offers</span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-links">
                        <h3>Helpful Links</h3>
                        <ul>
                            <li><a href="{{ route('contact') }}"><span>Contact</span></a></li>
                            <li><a href="{{ route('privacy-policy') }}"><span>Privacy Policy</span></a></li>
                            <li><a href="{{ route('terms') }}"><span>Terms of Use</span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-links">
                        <h3>Account</h3>
                        <ul>
                            @if (auth()->check())
                                <li><a href="{{ route("account") }}"><span>My Account</span></a></li>
                            @else
                                <li><a href="#account-login-popup" id="account-login-popup-trigger" class="popup-with-zoom-anim"><span>Log In</span></a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12">
                    <h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>
                    <p>Weekly breaking news, analysis and cutting edge advices on job searching.</p>
                    <form action="{{ route('newsletter-subscription') }}" method="post" class="newsletter">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your email address" required>
                        <button type="submit"><i class="icon-feather-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    © {{ date("Y") }} <strong>{{ config("app.name") }}</strong>. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>

</div>
