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
                <div class="contest-user-counts d-flex align-items-center flex-wrap">
                    @if (!is_null($user->country))
                        <div class="each-contest-user-count">
                            <h6 class="text-white">
                                Location
                            </h6>
                            <h5 class="text-white mb-0">
                                {{ $user->country->name }}
                            </h5>
                        </div>
                    @endif
                    <div class="each-contest-user-count">
                        <h6 class="text-white">
                            Offers
                        </h6>
                        <h5 class="text-white mb-0">
                            {{ $user->paid_project_manager_offers->count() + $user->freelancer_offers->count() }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="single-page-header mb-0 d-none" data-background-image="{{ asset('/images/create-contest-banner.png') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image freelancer-avatar">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="">
                                @else
                                    <img src="{{ asset('_home/images/user-avatar-big-02.jpg') }}" alt="">
                                @endif
                            </div>
                            <div class="header-details">
                                <h3>
                                    {{ $user->full_name }}
                                    <span><i class="fa fa-user"></i> {{ $user->username }}</span>
                                </h3>
                                <ul>
                                    <li><div class="star-rating" data-rating="5.0"></div></li>
                                    <li><img class="flag" src="{{ asset('_home/images/flags/de.svg') }}" alt=""> Germany</li>
                                    @if ($user->freelancer && $user->freelancer_profile && $user->freelancer_profile->verified)
                                        <li>
                                            <div class="verified-badge-with-title">Verified</div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 profile-top-right">
                    @if ($user->freelancer && (!auth()->check() || ($user->id != auth()->user()->id)))
                        <button class="btn btn-success btn-block text-uppercase">Send me an offer <i class="icon-material-outline-arrow-right-alt"></i></button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @include('layouts.section-header', ['header' => 'Offers'])

        <div class="listings-container compact-list-layout margin-top-10">
            @forelse ($offers as $offer)
                @php $offer = json_decode(json_encode($offer)); @endphp
                @if ($user->freelancer)
                    @include("offers.freelancer.freelancer-offer-row", ["offer" => $offer])
                @else
                    @include("offers.project-manager.project-manager-offer-row", ["offer" => $offer])
                @endif
                {{-- <div
                    class="job-listing">
                    <div class="job-listing-details">
                        <div class="job-listing-company-logo listing-user-avatar">
                            @if (is_null($offer->user->avatar))
                                <img src="{{ asset('images/user-avatar-placeholder.png') }}" alt="">
                            @else
                                <img src="{{ asset("storage/avatars/{$offer->user->avatar}") }}" alt="">
                            @endif
                        </div>
                        <div class="job-listing-description">
                            <a href="{{ route('offers.project-managers.show', ['offer_slug' => $offer->slug]) }}">
                                <h3 class="job-listing-title text-black">
                                    {{ $offer->title }}
                                </h3>
                            </a>
                            <div class="job-listing-footer">
                                <ul class="text-small">
                                    <li class="d-none">
                                        <i class="icon-material-outline-business"></i>
                                        Hexagon
                                        <div class="verified-badge" title="Verified Employer"
                                            data-tippy-placement="top"></div>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-bookmark-border"></i>
                                        {{ $offer->sub_category->title }}
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-business-center"></i>
                                        @if ($offer->minimum_designer_level == 0)
                                            Any designer can apply
                                        @else
                                            Only designers with minimum of {{ $offer->minimum_designer_level }} can
                                            apply
                                        @endif
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-access-time"></i>
                                        {{ \Carbon\Carbon::parse($offer->created_at)->diffForHumans() }}
                                    </li>
                                </ul>
                                @if (!$offer->payment)
                                    <div>
                                        <a href="{{ route('offers.project-managers.payment', ['offer' => $offer->id]) }}" class="btn btn-sm btn-info">
                                            Make Payment Now
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <span class="bookmark-icon"></span>
                    </div>
                </div> --}}
            @empty
                <div class="alert alert-info">
                    <small>
                        There are no offers available at the moment.
                    </small>
                </div>
            @endforelse
        </div>

        <div class="freelancers-container freelancers-list-layout margin-top-35 d-none">

            <div class="offers-headers mb-5 text-center">
                <a href="#" class="offers-header-each">
                    Offers by {{ $user->username }}
                </a>
            </div>

            {{-- @if ($user->freelancer && $user->freelancer_profile) --}}
            @forelse ($offers as $offer)
                <div class="freelancer">

                    <div class="freelancer-overview">
                        <div class="freelancer-overview-inner">

                            <span class="bookmark-icon"></span>

                            <div class="freelancer-name">
                                <h4>
                                    <a href="#">
                                        {{ ucfirst($offer['title']) }} <img class="flag" src="images/flags/gb.html" alt="" title="United Kingdom" data-tippy-placement="top">
                                    </a>
                                </h4>
                                {{-- <small>
                                    {{ $offer['sub_category']['title'] }}
                                </small>
                                <br> --}}
                                <small>
                                    {{ $offer['sub_category']['offer_category']['title'] }}
                                </small>
                                <div class="freelancer-rating">
                                    <div class="star-rating" data-rating="4.9"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="freelancer-details">
                        <div class="freelancer-details-list">
                            <ul>
                                <li>Location <strong><i class="icon-material-outline-location-on"></i> London</strong></li>
                                <li>Rate <strong>$60 / hr</strong></li>
                                <li>Job Success <strong>95%</strong></li>
                            </ul>
                        </div>
                        {{-- Check if offer is a project manager's offer or a freelancer's offer by checking for the "Minimum designer level" key on the offer array, which makes it a project manager's offer --}}
                        {{-- <a href="{{ route('offers.project-managers.show', ['offer_slug' => $offer['slug']]) }}" class="button button-sliding-icon ripple-effect"> --}}
                        <a href="{{ route((!array_key_exists('minimum_designer_level', $offer) ? 'offers.freelancers.index' : 'offers.project-managers.show'), ['offer_slug' => $offer['slug']]) }}" class="button button-sliding-icon ripple-effect">
                            View Offer
                            <i class="icon-material-outline-arrow-right-alt"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="no-offer-messages row">
                    <div class="alert alert-info">
                        <small>
                            {{ ucfirst($user->username) }} has no offers at the moment
                        </small>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="clearfix d-none"></div>
        <div class="row mb-5 d-none">
            <div class="col-md-12">
                <!-- Pagination -->
                <div class="pagination-container margin-top-40 margin-bottom-60">
                    <nav class="pagination justify-content-md-center">
                        <ul>
                            <li class="pagination-arrow">
                                <a {{ 1 >= $page_number ? '' : 'href='.route('offers.user', ['username' => $user->username]).'?page='.($page_number - 1) }} class="ripple-effect">
                                    <i class="icon-material-outline-keyboard-arrow-left"></i>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $total_pages; $i++)
                                <li>
                                    <a {{ $i == $page_number ? '' : 'href='.route('offers.user', ['username' => $user->username]).'?page='.$i }} class="{{ $i == $page_number ? 'current-page' : '' }} ripple-effect">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor
                            <li class="pagination-arrow">
                                <a {{ $total_pages <= $page_number ? '' : 'href='.route('offers.user', ['username' => $user->username]).'?page='.($page_number + 1) }} class="ripple-effect">
                                    <i class="icon-material-outline-keyboard-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
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
