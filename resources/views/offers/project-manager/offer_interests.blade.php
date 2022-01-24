@extends('layouts.app')

@section('page_styles')
    <style>
        .offers-headers {
            /* display: block; */
            flex: 1;
        }
        .offers-header-each {
            background-color: white;
            padding: 15px 30px;
            color: black;
            text-transform: uppercase;
            border-radius: 3px;
            border-top: 2px solid #e09426;
            box-shadow: 3px 3px 10px 3px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
            margin-left: 10px;
        }
        .offers-header-each:hover {
            color: black;
            box-shadow: 3px 5px 20px 3px rgba(0, 0, 0, 0.15);
        }
        .no-offer-message {
            flex: 1;
        }

        .contests-banner-inner {
            padding-top: 50px;
            padding-bottom: 30px;
        }
        .contest-user-card-avatar {
            height: 70px;
            max-width: 70px;
            margin-right: 10px;
            object-fit: contain;
        }
        .each-contest-user-count {
            margin-right: 30px;
            text-align: center;
        }

        .each-contest-user-count h6 {
            font-size: 10px;
            text-transform: uppercase;
        }
    </style>
@endsection

@section('page_content')
    <div class="contests-banner mb-4">
        <div class="contests-banner-inner">
            <div class="container">
                <div class="contest-user-card d-flex align-items-center flex-wrap mb-4">
                    <div class="contest-user-card-avatar">
                        <img src="{{ asset(is_null($user->avatar) ? ("images/user-avatar-placeholder.png") : ("storage/avatars/{$user->avatar}")) }}" alt="" class="img-thumbnail">
                    </div>
                    <h3 class="text-white mb-0">
                        {{ trim($user->full_name) != '' ? $user->full_name : $user->email }}
                        @if (!$user->freelancer)
                            <div style="font-size: small;color: #ddd;">Project Manager</div>
                        @endif
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @include('layouts.section-header', ['header' => "Here are all your Freelancer Offer Interests", 'icon' => 'icon-material-outline-announcement'])

        <div class="listings-container compact-list-layout margin-top-10">
            @forelse ($interests as $interest)
                {{-- @include("offers.freelancer.freelancer-offer-row", ["offer" => $offer]) --}}

                <div class="contest-row-card">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="context-image-container">
                            <a href="{{ route('offers.freelancers.show', ['offer_slug' => $interest->offer->slug]) }}">
                                {{-- <img src="{{ asset(is_null($interest->offer->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$interest->offer->user->avatar}") }}"
                                    alt=""> --}}
                                <img src="{{ asset($file_location.$interest->offer->sub_category->picture) }}"
                                    alt="">
                            </a>
                        </div>
                        <div class="contest-info-container">
                            <a href="{{ route('offers.freelancers.show', ['offer_slug' => $interest->offer->slug]) }}">
                                <div class="contest-row-card-title">
                                    {{ $interest->offer->title }}
                                </div>
                            </a>
                            <div class="contest-row-card-description">
                                {{ substr($interest->offer->description, 0, 100) }}...
                            </div>
                            <div class="context-row-card-tags d-flex flex-wrap">
                                <div class="context-row-card-tag-each border-dark">
                                    <i class="icon-line-awesome-star"></i>
                                    {{ $interest->offer->sub_category->offer_category->title }}
                                </div>
                            </div>
                            @if($interest->status == 'accepted' && !$interest->is_paid)
                                <div class="context-row-card-tags d-flex flex-wrap">
                                    <a href="{{ route('offers.freelancers.payment', ['interest' => $interest]) }}" class="btn btn-primary">Proceed To Payment</a>
                                    {{-- <div class="context-row-card-tag-each border-dark">
                                        <i class="icon-line-awesome-star"></i>
                                        {{ $interest->offer->sub_category->offer_category->title }}
                                    </div> --}}
                                </div>
                            @endif
                        </div>
                        <div class="contest-row-card-right d-flex flex-column justify-content-center">
                            <div class="contest-row-card-right-each">
                                <i class="icon-material-outline-local-atm"></i>
                                <span>
                                    {{-- {{ $interest->offer->currency == 'dollar' ? '$' : '₦' }}{{ number_format($interest->offer->price) }} --}}
                                    {{ $user_currency == 'dollar' ? '$' : '₦' }}{{ number_format(intval(getUserCurrencyAmount($user_currency, $interest->price, $interest->currency, $dollar_rate)), 2) }}
                                </span>
                            </div>
                            {{-- <div class="contest-row-card-right-each">
                                <i class="icon-line-awesome-align-left"></i>
                                <span>
                                    {{ $offer->delivery_mode == 'continuous' ? 'Continuous' : 'One time' }}
                                </span>
                            </div>
                            <div class="contest-row-card-right-each">
                                <i class="icon-line-awesome-users"></i>
                                <span>
                                    {{ $offer->timeline }} day{{ $offer->timeline > 1 ? 's' : '' }}
                                </span>
                            </div> --}}
                        </div>

                        @if($interest->status == 'pending')
                            <div class="status-strip bg-secondary text-white d-none d-sm-block">
                                {{ $interest->status }}
                            </div>
                        @elseif($interest->status == 'accepted' && !$interest->is_paid)
                            <div class="status-strip bg-primary text-white d-none d-sm-block">
                                AWAITING PAYMENT
                            </div>
                        @elseif($interest->status == 'accepted')
                            <div class="status-strip bg-success text-white d-none d-sm-block">
                                {{ $interest->status }}
                            </div>
                        @else
                            <div class="status-strip bg-warning text-white d-none d-sm-block">
                                {{ $interest->status }}
                            </div>
                        @endif
                    </div>
                </div>


            @empty
                <div class="alert alert-info">
                    <small>
                        There are no offers available at the moment.
                    </small>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('page_scripts')
    <script type="text/javascript">
        const each_active_offer_head = $('.each-active-offer-head')
        // const each_active_offer_title = $('.each-active-offer-head-title')
        const each_active_offer_body = $('.each-active-offer-body')

        each_active_offer_head.on('click', (e) => {
            let data_ind = $(e.target).data('ind')

            if($('.offer-body-'+data_ind).css('display') == 'none') {
                $('.each-active-offer-body').hide()

                $('.offer-body-'+data_ind).fadeIn()
            } else {
                $('.each-active-offer-body').hide()
            }
            // $('.offer-body-'+data_ind).css('display', 'block')
        })
    </script>
@endsection
