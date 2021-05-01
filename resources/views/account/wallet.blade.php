@extends('account.layouts.app')

@section('page_styles')
    <style>
        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        .dollar-before::before {
            content: '$';
        }

    </style>
@endsection

@section('page_content')
    <div class="dashboard-headline d-none">
        <h3>Hello, {{ $user->username }}!</h3>
        <span>We are glad to see you again!</span>

        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="#">Home</a></li>
                <li>Dashboard</li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-12 col-sm-4">
            <div class="fun-fact" data-fun-fact-color="#efa80f">
                <div class="fun-fact-text">
                    <span>Available Balance</span>
                    <h4 class="dollar-before" style="font-size: 25px;font-weight: 400">
                        {{ number_format($user->wallet_balance) }}
                    </h4>
                </div>
                <div class="fun-fact-icon"><i class=" icon-line-awesome-money"></i></div>
            </div>

            <div class="dashboard-box main-box-in-row margin-top-0">
                <div class="headline">
                    <h3><i class=" icon-material-outline-account-balance-wallet"></i> Withdraw from Wallet</h3>
                </div>
                <div class="content p-3">
                    <div class="form-group margin-bottom-20">
                        <small for="">Select Currency</small>
                        <select name="currency" class="form-control" id="">
                            <option value="">--</option>
                            <option value="usd">USD</option>
                            <option value="ngn">NGN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <small for="">Amount</small>
                        <input type="number" min="0" name="amount" placeholder="" class="form-control">
                    </div>
                    {{-- <hr> --}}
                    <div>
                        <div class="form-group margin-bottom-20">
                            <small for="" class="bank-label">Bank</small>
                            <select name="bank" class="form-control" id="">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group account-number-container">
                            <small for="">Account Number</small>
                            <input type="text" class=" number-only" name="account_number" placeholder=""
                                class="form-control" maxlength="10">
                        </div>
                        <div class="form-group">
                            <small for="" class="account-name-label">Amount Name</small>
                            <input type="text" class="" name="account_name" placeholder="" class="form-control" readonly>
                        </div>
                    </div>

                    <button
                        class="btn btn-custom-primary btn-block margin-top-20 margin-bottom-10 text-uppercase withdraw-btn pt-2 pb-2">
                        <small>
                            Submit Request
                            <i class=" icon-feather-arrow-right"></i>
                        </small>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="dashboard-box main-box-in-row margin-top-0">
                <div class="headline">
                    <h3><i class=" icon-material-outline-account-balance-wallet"></i> Withdrawals</h3>
                </div>
                <div class="content">
                    <div class="table-responsive">
                        <table class="table table-striped margin-bottom-0 table-condensed">
                            <tr>
                                <th>
                                    Amount
                                </th>
                                <th>
                                    Transaction Reference
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Status
                                </th>
                            </tr>
                            @forelse ($withdrawals as $withdrawal)
                                <tr>
                                    <td>
                                        <small>
                                            {{ $withdrawal->currency == 'usd' ? '$' : '₦' }}{{ number_format($withdrawal->amount) }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $withdrawal->reference }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $withdrawal->created_at }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            @switch($withdrawal->reference)
                                                @case('approved')
                                                    <small class="text-success">Completed</small>
                                                @break
                                                @case('rejected')
                                                    <small class="text-danger">Rejected</small>
                                                @break
                                                @default
                                                    <small class="text-info">Pending</small>
                                            @endswitch
                                        </small>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center">
                                                <small>
                                                    Your withdrawal requests will appear here.
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_popups')
        <div class="modal fade" id="registerFreelancerModal" tabindex="-1" role="dialog"
            aria-labelledby="registerFreelancerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerFreelancerModalLabel">
                            {{-- Complete your profile below to become a freelancer --}}
                            Become a freelancer
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="nationality" class="form-control" multiple="multiple">
                                <option value="">Skills</option>
                                <option value="photoshop">Photoshop</option>
                                <option value="photoshop">XD</option>
                                <option value="photoshop">Paint</option>
                                <option value="photoshop">Corel Draw</option>
                            </select>
                        </div>
                        {{-- <div class="form-group">
                        <select name="nationality" class="form-control">
                            <option value="">Select Nationality</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->citizenship }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                        {{-- <div class="form-group">
                        <input type="text" class="form-control" name="" id="">
                    </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Proceed</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_scripts')
        <script>
            // $('#registerFreelancerModal').modal('show')
            $('select').select2();

            const currency_select = $('select[name=currency]')
            const bank_select = $('select[name=bank]')
            const amount_input = $('input[name=amount]')
            const account_name_input = $('input[name=account_name]')
            const account_number_input = $('input[name=account_number]')
            const withdraw_btn = $(".withdraw-btn")

            const dollar_banks = JSON.parse(`{!! json_encode($dollar_banks) !!}`)
            const naira_banks = JSON.parse(`{!! json_encode($naira_banks) !!}`)

            currency_select.on('change', function() {
                let selected_currency = currency_select.val()

                bank_select.html(`<option value="">Select</option>`)
                bank_select.val('')
                bank_select.trigger('change')

                if (selected_currency == 'ngn') {
                    // Show Naira Banks
                    naira_banks.map(naira_bank => {
                        bank_select.append(`<option value="${naira_bank.id}">${naira_bank.name}</option>`)
                    })
                    account_name_input.attr({
                        readonly: true
                    })
                    account_name_input.val('')
                    account_number_input.val('')
                    $('.account-name-label').text(`Account Name`)
                    $('.bank-label').text(`Bank`)
                    $('.account-number-container').show()
                } else if (selected_currency == 'usd') {
                    // Show Dollar Banks
                    dollar_banks.map(dollar_bank => {
                        bank_select.append(`<option value="${dollar_bank.key}">${dollar_bank.name}</option>`)
                    })
                    account_name_input.attr({
                        readonly: false
                    })
                    account_name_input.val('')
                    account_number_input.val('')
                    $('.account-name-label').text(`Email Address`)
                    $('.bank-label').text(`Account`)
                    $('.account-number-container').hide()
                }
            })

            withdraw_btn.on('click', function() {
                if (currency_select.val() == "") {
                    Snackbar.show({
                        text: `You need to select a valid currency.`,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                    return
                }
                if (amount_input.val() == "") {
                    Snackbar.show({
                        text: `You need to add a valid amount.`,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                    return
                }
                if (bank_select.val() == "") {
                    Snackbar.show({
                        text: `You need to select a valid bank / account.`,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                    return
                }

                if (currency_select.val() == 'ngn') {
                    if (account_number_input.val() == "") {
                        Snackbar.show({
                            text: `You need to add a valid account number.`,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#721c24'
                        });
                        return
                    }
                    if (account_name_input.val() == "") {
                        Snackbar.show({
                            text: `You need to add a valid account name.`,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#721c24'
                        });
                        return
                    }
                } else {
                    if (account_name_input.val() == "") {
                        Snackbar.show({
                            text: `You need to add a valid email address.`,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#721c24'
                        });
                        return
                    }
                }

                loading_container.show()

                let payload = {
                    _token,
                    currency: currency_select.val(),
                    amount: amount_input.val(),
                    bank: bank_select.val(),
                    account_number: account_number_input.val(),
                    account_name: account_name_input.val(),
                }

                fetch(`{{ route('account.wallet-withdrawal') }}`, {
                        method: 'post',
                        headers: {
                            'Accept': 'application/json',
                            'Content-type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    }).then(async response => {
                        let data = await response.json()

                        switch (response.status) {
                            case 200:
                                return data
                                break;
                            default:
                                throw new Error(data.message)
                                break;
                        }
                    })
                    .then(async responseJson => {
                        console.log("Success here", responseJson);

                        Snackbar.show({
                            text: `Success`,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: 'green'
                        });

                        setTimeout(() => {
                            window.location.reload()
                        }, 2000)
                        // loading_container.hide()
                    })
                    .catch(error => {
                        console.log("Error occurred: ", error);
                        Snackbar.show({
                            text: error.message, //`Error occurred, please try again`,
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
                        loading_container.hide()
                    })
            })

            bank_select.on('change', function() {
                account_name_input.val('')
                account_number_input.val('')
            })

            account_number_input.on('keyup', function(e) {
                // Check if currency is set to naira

                account_name_input.val('')

                if (currency_select.val() == 'ngn' && account_number_input.val().length >= 10 && bank_select.val() !=
                    '') {
                    // Fetch account name
                    loading_container.show()

                    account_number_input.attr({
                        readonly: true
                    })

                    let payload = {
                        _token,
                        bank: bank_select.val(),
                        account_number: account_number_input.val(),
                    }
                    fetch(`{{ route('account.verify-account-number') }}`, {
                            method: 'post',
                            headers: {
                                'Accept': 'application/json',
                                'Content-type': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        }).then(async response => {
                            let data = await response.json()

                            switch (response.status) {
                                case 200:
                                    return data
                                    break;
                                default:
                                    throw new Error(data.message)
                                    break;
                            }
                        })
                        .then(async responseJson => {
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

                            account_name_input.val(responseJson.account_name)

                            loading_container.hide()
                            account_number_input.removeAttr('readonly')
                        })
                        .catch(error => {
                            console.log("Error occurred: ", error);
                            Snackbar.show({
                                text: error.message, //`Error occurred, please try again`,
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
                            loading_container.hide()
                            account_number_input.removeAttr('readonly')
                        })
                }
            })

        </script>
    @endsection
