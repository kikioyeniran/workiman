@extends('layouts.app')

@section('page_styles')
    <style>
        .payment-tab {
            max-height: fit-content !important;
        }

        #login-form {
            display: none;
        }

    </style>
@endsection

@section('page_content')
    <div id="titlebar" class="gradient margin-bottom-30">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h2>Make payment for this offer</h2>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="{{ route('contests.create') }}">Create Contest</a></li>
                            <li>Make Payment</li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 content-right-offset mb-5">

                <!-- Payment Methods Accordion -->
                <div class="payment">

                    <div class="payment-tab payment-tab-active">
                        <div class="payment-tab-trigger">
                            <h5 class="margin-top-20 margin-bottom-10">Offer Title</h5>
                        </div>

                        <div class="payment-tab-content">
                            <p>{{ $offer->title }}</p>
                        </div>
                    </div>


                    <div class="payment-tab payment-tab-active">
                        <div class="payment-tab-trigger">
                            <h5 class="margin-top-20 margin-bottom-10">
                                Payment Details
                            </h5>
                            <img class="payment-logo" src="https://i.imgur.com/IHEKLgm.png" alt="">
                        </div>

                        <div class="payment-tab-content">
                            <div class="alert alert-success">
                                <small>
                                    @if ($user)
                                        Hello {{ $user->username }},
                                    @endif
                                    Your offer has been created already, but you need to make a down payment for the
                                    offer to be live and active
                                </small>
                            </div>
                            <div class="payment-form-row">

                                @if (!$user)
                                    <form action="{{ route('login') }}" method="POST" class="row" id="login-form">
                                        @csrf
                                        <input type="hidden" name="contest_id" value="{{ $offer->id }}" required>
                                        <div class="col-md-6">
                                            <div class="card-label">
                                                <input id="username" name="username" required type="email"
                                                    placeholder="Email Address">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card-label">
                                                <input id="password" name="password" placeholder="Password" required
                                                    type="password">
                                            </div>
                                        </div>

                                        <div class="col-md-12 pt-4">
                                            <button type="submit" class="button big ripple-effect">Sign In</button>
                                            <div class="mt-4">
                                                Don't have an account yet?
                                                <a href="#" class="open-register-form">
                                                    Click here to register now!
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ route('register') }}" method="POST" class="row" id="register-form">
                                        @csrf
                                        <input type="hidden" name="contest_id" value="{{ $offer->id }}" required>
                                        <input type="hidden" name="account_type_radio" value="employer" required>
                                        <div class="col-md-6">
                                            <div class="card-label">
                                                <input id="username" name="username" required type="text"
                                                    placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-label">
                                                <input id="email" name="email" required type="email"
                                                    placeholder="Email Address">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card-label">
                                                <input id="password" name="password" placeholder="Password" required
                                                    type="password">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card-label">
                                                <input id="password_confirmation" name="password_confirmation"
                                                    placeholder="Password" required type="password">
                                            </div>
                                        </div>

                                        <div class="col-12 pt-4">
                                            <button type="submit" class="button big ripple-effect">Create account</button>
                                            <div class="mt-4">
                                                Already have an account?
                                                <a href="#" class="open-login-form">
                                                    Click here to login
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
                <!-- Payment Methods Accordion / End -->

                @if ($user)
                    <button onclick="javascript: payWithPaystack()"
                        class="button big ripple-effect margin-top-40 margin-bottom-65">Proceed Payment</button>
                @endif
            </div>


            <!-- Summary -->
            <div class="col-xl-4 col-lg-4 margin-top-0 margin-bottom-60">

                <!-- Summary -->
                <div class="boxed-widget summary margin-top-0">
                    <div class="boxed-widget-headline">
                        <h3>Summary</h3>
                    </div>
                    <div class="boxed-widget-inner">
                        <ul>
                            <li>Contest Price <span>{{ auth()->user()->is_nigeria == true ? '₦' : '$' }}{{ number_format($offer->budget) }}</span></li>

                            <li class="total-costs">Final Price <span>{{ auth()->user()->is_nigeria == true ? '₦' : '$' }}{{ number_format($offer->budget) }}</span></li>
                        </ul>
                    </div>
                </div>
                <!-- Summary / End -->

                <!-- Checkbox -->
                <div class="checkbox margin-top-30">
                    <input type="checkbox" id="terms-agreement">
                    <label for="terms-agreement"><span class="checkbox-icon"></span> I agree to the <a href="#">Terms and
                            Conditions</a> and the <a href="#">Automatic Renewal Terms</a></label>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="https://js.paystack.co/v1/inline.js"></script>

    <script>
        const login_form = $('form#login-form')
        const register_form = $('form#register-form')

        const open_login_form = $('.open-login-form')
        const open_register_form = $('.open-register-form')

        open_register_form.on('click', () => {
            login_form.hide()
            register_form.css('display', 'flex')
        })

        open_login_form.on('click', () => {
            register_form.hide()
            login_form.css('display', 'flex')
        })

        // Save contest payment

        function payWithPaystack() {

            if (!$('#terms-agreement').is(':checked')) {
                Snackbar.show({
                    text: `You need to agree to our Terms & Conditions to continue`,
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }

            // let amount = parseFloat('{{ $offer->budget }}')
            let amount = parseFloat('{{ getUserCurrencyAmount($user_currency, $offer->budget, $offer->currency, $dollar_rate) }}')
            let currency_val = `{{ $user_currency }}`;
            let currency = currency_val == 'dollar' ? 'USD' : 'NGN';

            var handler = PaystackPop.setup({
                key: `{{ config('paystack.test.public_key') }}`,
                email: '{{ $user ? $user->email : '' }}',
                amount: amount * 100,
                firstname: '{{ $user ? $user->username : '' }}',
                ref: '' + Math.floor((Math.random() * 1000000000) + 1),
                label: "Contest Payment",
                currency: currency,
                onClose: function() {
                    // alert('Window closed.');
                },
                callback: function(response) {
                    console.log(response);

                    var message = 'Payment complete! Reference: ' + response.reference;
                    saveContestPayment(amount, response.reference, 'paystack')
                }
            });

            handler.openIframe();
        }


        function saveContestPayment(amount, payment_reference, payment_method) {
            loading_container.show();
            payload = {
                _token,
                payment_reference,
                payment_method,
                amount
            }
            fetch(`{{ route('offers.project-managers.payment', ['offer' => $offer->id]) }}`, {
                    method: 'post',
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }).then(response => response.json())
                .then(async responseJson => {
                    if (responseJson.success) {
                        console.log("Success here", responseJson);
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: 'green'
                        });
                        setTimeout(() => {
                            window.location = `${webRoot}offers/project-managers/${responseJson.slug}`;
                        }, 2000)
                    } else {
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '721c24'
                        });
                        $('html, body').animate({
                            scrollTop: $('#wrapper').offset().top
                        }, 500);
                        loading_container.hide();
                    }

                })
                .catch(error => {
                    console.log("Error occurred: ", error);
                    Snackbar.show({
                        text: `Error occurred, please try again`,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                    $('html, body').animate({
                        scrollTop: $('#wrapper').offset().top
                    }, 500);
                    loading_container.hide();
                })
        }
    </script>
@endsection
