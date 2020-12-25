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
    </style>
@endsection

@section('page_content')
    <div class="single-page-header mb-0" data-background-image="{{ asset('/images/create-contest-banner.png') }}">
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
        <div class="freelancers-container freelancers-list-layout margin-top-35">

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
                        <a href="{{ route((!array_key_exists('minimum_designer_level', $offer) ? 'offers.freelancers' : 'offers.project-managers.show'), ['id' => $offer['id']]) }}" class="button button-sliding-icon ripple-effect">
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

        <div class="clearfix"></div>
        <div class="row mb-5">
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
