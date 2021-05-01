@extends('account.layouts.app')

@section('page_styles')
    <style>
        .dropup .dropdown-toggle::after,
        .dropdown-toggle::after {
            display: none;
        }

        .payment-method-email,
        .payment-method-bank {
            display: none;
        }

        .keywords-list {
            float: none;
        }

    </style>
@endsection

@section('page_content')

    <div class="dashboard-headline mb-3">
        <div class="row">
            <div class="col">
                <h3>Settings</h3>
            </div>

            <div class="col text-right">
                @if ($user->freelancer)
                    <button class="btn btn-custom-primary btn-sm">Freelancer</button>
                @else
                    <button class="btn btn-custom-primary btn-sm">Project Manager</button>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <form action="{{ route('account.settings') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="setting" value="basic">
                <div class="dashboard-box margin-top-0">
                    <div class="headline">
                        <h3><i class="icon-material-outline-account-circle"></i> Basic Info</h3>
                    </div>

                    <div class="content with-padding padding-bottom-0">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">
                                    <img class="profile-pic"
                                        src="{{ asset($user->avatar ? 'storage/avatars/' . $user->avatar : 'images/user-avatar-placeholder.png') }}"
                                        alt="" />
                                    <div class="upload-button"></div>
                                    <input class="file-upload" type="file" accept="image/*" name="avatar"
                                        {{ $user->avatar ? '' : 'required' }} />
                                </div>
                            </div>

                            <div class="col">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>First Name</h5>
                                            <input type="text" class="with-border" name="first_name"
                                                value="{{ $user->first_name }}" required>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Last Name</h5>
                                            <input type="text" class="with-border" name="last_name"
                                                value="{{ $user->last_name }}" required>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>{{ !$user->freelancer ? 'Company Name / ' : '' }}Username</h5>
                                            <input type="text" class="with-border" name="username"
                                                value="{{ $user->username }}" required>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Country</h5>
                                            <select name="country" class="selectpickers" required>
                                                <option value="">--</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $user->country_id == $country->id ? 'selected' : '' }}
                                                        data-calling="{{ $country->calling_code }}">
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
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
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>About Me</h5>
                                            <textarea class="with-border" name="about" required>{{ $user->about }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-custom-primary px-5 text-uppercase">Save</button>
                </div>
            </form>
        </div>
    </div>

    @if ($user->freelancer)
        <div class="row mt-5">
            <div class="col-xl-12">
                <form action="{{ route('account.settings') }}" method="POST" enctype="multipart/form-data"
                    id="skills-form">
                    @csrf
                    @method('put')
                    <input type="hidden" name="setting" value="skills">
                    <input type="hidden" name="skills" value="">
                    <input type="hidden" name="awards" value="">

                    <div class="dashboard-box margin-top-0">
                        <div class="headline">
                            <h3><i class="icon-feather-star"></i> Skills & Experience</h3>
                        </div>

                        <div class="content with-padding padding-bottom-0">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>Link to Portfolio</h5>
                                        <input type="text" class="with-border"
                                            value="{{ $user->freelancer_profile ? $user->freelancer_profile->portfolio : '' }}"
                                            name="portfolio">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>Social Media Link</h5>
                                        <input type="text" class="with-border"
                                            value="{{ $user->freelancer_profile ? $user->freelancer_profile->social_media : '' }}"
                                            name="social_media">
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="section-headline">
                                        <h5>Awards (optional)</h5>
                                    </div>

                                    <div class="keywords-container">
                                        <div class="keyword-input-container">
                                            <input type="text" class="keyword-input with-border" placeholder="ACE, ACA" />
                                            <button class="keyword-input-button ripple-effect"><i
                                                    class="icon-material-outline-add"></i></button>
                                        </div>
                                        @if ($user->freelancer)
                                            <div class="keywords-list" id="awards-keywords">
                                                @if ($user->freelancer_profile)
                                                    @foreach (explode(',', $user->freelancer_profile->awards) as $award)
                                                        <span class="keyword"><span class="keyword-remove"></span><span
                                                                class="keyword-text">{{ $award }}</span></span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="section-headline">
                                        <h5>Skills (Maximum of 10 skills)</h5>
                                    </div>

                                    <div class="keywords-container">
                                        <div class="keyword-input-container">
                                            <input type="text" class="keyword-input with-border" placeholder="Corel Draw" />
                                            <button class="keyword-input-button ripple-effect"><i
                                                    class="icon-material-outline-add"></i></button>
                                        </div>
                                        @if ($user->freelancer)
                                            <div class="keywords-list" id="skills-keywords">
                                                @if ($user->freelancer_profile)
                                                    @foreach (explode(',', $user->freelancer_profile->skills) as $skill)
                                                        <span class="keyword"><span class="keyword-remove"></span><span
                                                                class="keyword-text">{{ $skill }}</span></span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Attachments (Cover Letter)</h5>
                                        <input type="file" class="with-border" value="" name="cover_letter"
                                            placeholder="ACE, ACA">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-custom-primary px-5 text-uppercase" id="submit-skills">Save
                            Skills</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="row mt-5 d-none">
        <div class="col-xl-12">
            <form action="{{ route('account.settings') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="setting" value="payment">
                <div class="dashboard-box margin-top-0">
                    <div class="headline">
                        <h3><i class="icon-material-outline-account-balance-wallet"></i> Payment Method</h3>
                    </div>

                    <div class="content with-padding padding-bottom-0">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>Select a Payment Method</h5>
                                    <select name="payment_method" class="selectpickers" required>
                                        <option value="">--</option>
                                        <option value="bank"
                                            {{ $user->payment_method && $user->payment_method->method == 'bank' ? 'selected' : '' }}>
                                            Bank</option>
                                        <option value="paypal"
                                            {{ $user->payment_method && $user->payment_method->method == 'paypal' ? 'selected' : '' }}>
                                            Paypal</option>
                                        <option value="skrill"
                                            {{ $user->payment_method && $user->payment_method->method == 'skrill' ? 'selected' : '' }}>
                                            Skrill</option>
                                        <option value="payoneer"
                                            {{ $user->payment_method && $user->payment_method->method == 'payoneer' ? 'selected' : '' }}>
                                            Payoneer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 payment-method-email"
                                style="display: {{ $user->payment_method && $user->payment_method->method != 'bank' ? 'block' : 'none' }}">
                                <div class="submit-field">
                                    <h5>Payment Email Address</h5>
                                    <input type="text" class="input-email" placeholder=""
                                        value="{{ $user->payment_method && $user->payment_method->method != 'bank' ? $user->payment_method->email : '' }}"
                                        name="payment_email">
                                </div>
                            </div>
                        </div>
                        <div class="row payment-method-bank"
                            style="display: {{ $user->payment_method && $user->payment_method->method == 'bank' ? 'flex' : 'none' }}">
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Bank</h5>
                                    <select name="bank" class="selectpickers">
                                        <option value="">--</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}"
                                                {{ $user->payment_method && $user->payment_method->method == 'bank' && $user->payment_method->bank == $bank->id ? 'selected' : '' }}>
                                                {{ $bank->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Account Number</h5>
                                    <input type="text" class="input-text" placeholder=""
                                        value="{{ $user->payment_method && $user->payment_method->method == 'bank' ? $user->payment_method->account_number : '' }}"
                                        name="account_number">
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Account Name</h5>
                                    <input type="text" class="input-text" placeholder=""
                                        value="{{ $user->payment_method && $user->payment_method->method == 'bank' ? $user->payment_method->account_name : '' }}"
                                        name="account_name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-custom-primary px-5 text-uppercase">Save Payment Method</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-xl-12">
            <form action="{{ route('account.settings') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="setting" value="password">
                <div class="dashboard-box margin-top-0">
                    <div class="headline">
                        <h3><i class="icon-material-outline-lock"></i> Account Security</h3>
                    </div>

                    <div class="content with-padding padding-bottom-0">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Current Password</h5>
                                    <input type="password" class="input-text" placeholder="" name="password_old" required>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>New Password</h5>
                                    <input type="password" class="input-text" placeholder="" name="password" required>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Confirm Password</h5>
                                    <input type="password" class="input-text" placeholder="" name="password_confirmation"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-custom-primary px-5 text-uppercase">Save Password</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('page_scripts')
    <script>
        const submit_skills = $('#submit-skills')
        const skills_form = $('form#skills-form')
        const portfolio_input = $('input[name=portfolio]')
        const social_media_input = $('input[name=social_media]')
        const awards_input = $('input[name=awards]')
        const skills_input = $('input[name=skills]')
        const payment_method_select = $('select[name=payment_method]')
        const bank_select = $('select[name=bank]')
        const account_number_input = $('input[name=account_number]')
        const account_name_input = $('input[name=account_name]')
        const payment_email_input = $('input[name=payment_email]')

        const payment_method_email = $('.payment-method-email')
        const payment_method_bank = $('.payment-method-bank')

        let submit_skill_form = false

        let awards = []
        let skills = []

        const awards_keywords_container = $('#awards-keywords')
        const skills_keywords_container = $('#skills-keywords')

        const country_select = $("select[name=country]")

        country_select.on('change', (e) => {
            let selected_country = $(e.target).find('option:selected')

            if (selected_country.val() != '') {
                let calling_code = selected_country.data('calling')
                // console.log($(e.target), calling_code);

                $('#calling-code').html('+' + calling_code)
            } else {
                $('#calling-code').html('<i class="icon-feather-phone"></i>')
            }

        })

        payment_method_select.on('change', (e) => {
            let selected_payment = $(e.target).find('option:selected')
            console.log(selected_payment.val());


            if (payment_method_select.val() == '') {
                payment_method_email.hide();
                payment_method_bank.hide();
            } else if (payment_method_select.val() == 'bank') {
                bank_select.attr({
                    'required': true
                })
                account_name_input.attr({
                    'required': true
                })
                account_number_input.attr({
                    'required': true
                })
                payment_email_input.removeAttr('required')
                payment_method_email.hide();
                payment_method_bank.slideDown().css('display', 'flex');
            } else {
                bank_select.removeAttr('required')
                account_name_input.removeAttr('required')
                account_number_input.removeAttr('required')
                payment_email_input.attr({
                    'required': true
                })
                payment_method_bank.hide();
                payment_method_email.slideDown().css('display', 'block');
            }

        })

        skills_form.on('submit', (e) => {
            // alert(submit_skill_form.toString())
            if (!submit_skill_form) {
                e.preventDefault()
            }
        })

        submit_skills.on('click', (e) => {
            awards = [];
            skills = [];

            awards_keywords = awards_keywords_container.find('span.keyword-text')
            skills_keywords = skills_keywords_container.find('span.keyword-text')

            $.each(awards_keywords, (key, award) => {
                awards.push($(award).text())
            })

            $.each(skills_keywords, (key, skill) => {
                skills.push($(skill).text())
            })

            if (portfolio_input.val() == '') {
                Snackbar.show({
                    text: 'Please add your portfolio link!',
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
            } else if (social_media_input.val() == '') {
                Snackbar.show({
                    text: 'Please add your social media link!',
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
            } else if (skills.length == 0) {
                Snackbar.show({
                    text: 'Please add your skills!',
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
            } else {
                awards_input.val(awards)
                skills_input.val(skills)

                // Go ahead and submit form
                submit_skill_form = true
                skills_form.submit()
            }

        })

    </script>
@endsection
