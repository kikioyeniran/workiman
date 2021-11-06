@extends('layouts.app')

@section('page_styles')
    <style type="text/css">
        .select2-container--default .select2-selection--single {
            border: 0;
        }

        .select2-search--dropdown {
            display: none;
        }

        .category-box {
            border: 1px solid #f8e7ce;
            /* margin: 0px 15px; */
        }

        .category-box-icon {
            margin-bottom: 20px;
        }

        .category-box-icon i {
            font-size: 70px;
        }

        .category-box-icon img {
            height: 100px;
            object-fit: contain;
            max-width: 100%;
        }

        .how-it-works-video-container {
            background-color: rgba(0, 0, 0, .5);
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 1000;
            top: 0;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .how-it-works-inner {
            max-width: 70%;
            max-height: 60vh;
        }

        .how-it-works-inner video {
            max-width: 100%;
            max-height: 100%;
        }

        .how-it-works-video-container-close {
            text-align: right;
            font-size: 40px;
            color: white;
        }

        .how-it-works-video-container-close span {
            padding: 5px;
            cursor: pointer;
            border: 1px solid #f0f0f0;
            border-radius: 3px;
            margin-bottom: 10px;
        }

        .show-how-it-works-video {
            cursor: pointer;
        }

        .banner-right-w-content {
            max-width: 300px;
        }

        .banner-right-w-content>div:first-child {
            color: var(--primary-color);
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .banner-right-w-content>div:last-child {
            font-size: small;
        }

        .banner-search-dropdown {
            flex: inherit;
        }

        .home-testimonials-container {
            margin-top: 50px;
        }

        .home-testimonials-each>div {
            background-color: white;
            max-width: 80%;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 3px 3px 15px 7px rgba(0, 0, 0, .05);
            margin: 20px;
        }

        .home-testimonials-each>div p {
            font-size: 12px;
        }

        .home-testimonials-each>div small {
            font-size: 10px;
            color: #888;
        }

        .home-testimonials-each-bottom {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .home-testimonials-each-bottom img {
            height: 40px;
            object-fit: contain;
            width: 40px !important;
            border-radius: 50%;
            margin-right: 10px;
        }

        .owl-theme .owl-controls .owl-page {
            display: inline-block;
        }

        .owl-theme .owl-controls .owl-page span {
            background: none repeat scroll 0 0 #869791;
            border-radius: 20px;
            display: block;
            height: 12px;
            margin: 5px 7px;
            opacity: 0.5;
            width: 12px;
        }

        @media(min-width: 992px) {
            .intro-banner>.container {
                max-width: 80%;
            }

            .banner-right-w-container {
                /* margin-top: -70px; */
            }
        }

    </style>
@endsection

@section('page_content')
    <div class="how-it-works-video-container">
        <div class="how-it-works-inner">
            <div class="how-it-works-video-container-close">
                <span class="material-icons">close</span>
            </div>
            <video id="how-it-works-video" src="{{ asset('video/intro.mp4') }}" controls></video>
        </div>
    </div>

    <!-- add class "disable-gradient" to enable consistent background overlay -->
    {{-- <div class="intro-banner" data-background-image="{{ asset('_home/images/home-background.jpgs') }}"> --}}
    <div class="intro-banner disable-gradient">
        <div class="container">

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="banner-headline">
                                <h3>
                                    <strong>
                                        Welcome to <strong class="color">{{ config('app.name') }}</strong>
                                    </strong>
                                    <br>
                                    <span>
                                        {{-- Browse through our top skilled freelancers and project managers. --}}
                                        Browse through our projects, top skilled freelancers and project managers
                                    </span>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class=" mt-3">
                        <button class="btn btn-default d-flex align-items-center show-how-it-works-video pl-0">
                            <span class="material-icons">play_circle_filled</span>
                            <span class="ml-1">How it works</span>
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('search') }}" method="get">
                                <div class="intro-banner-search-form margin-top-70">
                                    <div class="intro-search-field with-autocomplete">
                                        <label for="autocomplete-input" class="field-title ripple-effect">What do you
                                            need?</label>
                                        <input name="keyword" type="text" placeholder="Logo Design" required>
                                        {{-- <div class="input-with-icon"> --}}
                                        {{-- <i class="icon-material-outline-location-on"></i> --}}
                                        {{-- </div> --}}
                                    </div>

                                    <div class="intro-search-field banner-search-dropdown">
                                        <label for="intro-keywords" class="field-title ripple-effect d-none">What job you
                                            want?</label>
                                        {{-- <input id="intro-keywords" type="text" placeholder="Job Title or Keywords"> --}}
                                        <select name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="freelancers">Freelancer Offers</option>
                                            <option value="project-managers">Project Manager Offers</option>
                                            <option value="contests">Contests</option>
                                        </select>
                                    </div>

                                    <div class="intro-search-button">
                                        <button class="button ripple-effect" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="intro-stats margin-top-45 hide-under-992px">
                                <li>
                                    <strong class="counter">
                                        {{ number_format(\App\Contest::count()) }}
                                    </strong>
                                    <span>
                                        Contests created
                                    </span>
                                </li>
                                <li>
                                    <strong class="counter">
                                        {{ number_format(\App\User::where('freelancer', true)->count()) }}
                                    </strong>
                                    <span>
                                        Freelancers
                                    </span>
                                </li>
                                <li>
                                    <strong class="counter">
                                        {{ number_format(\App\User::where('freelancer', false)->count()) }}
                                    </strong>
                                    <span>Project Managers</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 offset-md-1 owl-carousel banner-right-w-carousel">
                    {{-- <div class="owl-carousel banner-right-w-carousel"> --}}
                    @foreach ($sliders as $slider)
                        @if(count($sliders) > 0)
                            <div class="banner-right-w-container">
                                <div class="banner-right-w-image">
                                    <img src="{{ asset($file_location.$slider->picture) }}" alt="">
                                </div>
                                <div class="banner-right-w-content">
                                    <div>
                                        {{ $slider->large_text }}
                                    </div>
                                    <div>
                                        {{ $slider->small_text }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="banner-right-w-container">
                                <div class="banner-right-w-image">
                                    <img src="{{ asset('images/banners/w.png') }}" alt="">
                                </div>
                                <div class="banner-right-w-content">
                                    <div>
                                        Ariadna
                                    </div>
                                    <div>
                                        Content writer and proof reading expert since 2021. <span>$81K earned</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <div class="section white padding-top-85 padding-bottom-85">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <div class="section-headline centered margin-bottom-15">
                        <h3>Popular Contest Categories</h3>
                    </div>

                    <div class="categories-container row">

                        @foreach ($contest_categories as $contest_category)
                            <div class=" col-sm-3">
                                <a href="{{ route('contests.index', ['category' => $contest_category->id]) }}">
                                    <div class="category-box">
                                        <div class="category-box-icon">
                                            {{-- <i class="icon-line-awesomes la la-{{ $contest_category->icon }}"></i> --}}
                                            <img src="{{ asset('storage/category-icons/' . $contest_category->icon) }}"
                                                alt="">
                                        </div>
                                        <div class="category-box-counter d-none">
                                            {{ \App\Contest::whereHas('payment')->whereHas('sub_category', function ($sub_category_query) use ($contest_category) {
        $sub_category_query->where('contest_category_id', $contest_category->id);
    })->count() }}
                                        </div>
                                        <div class="category-box-content">
                                            <h3>
                                                {{ $contest_category->title }}
                                            </h3>
                                            <p class="d-none">
                                                @foreach ($contest_category->contest_sub_categories->take(2) as $contest_sub_category_key => $contest_sub_category)
                                                    @if ($contest_sub_category_key != 0)
                                                        ,
                                                    @endif
                                                    {{ $contest_sub_category->title }}
                                                @endforeach
                                                @if ($contest_category->contest_sub_categories->count() > 2)
                                                    and {{ $contest_category->contest_sub_categories->count() - 2 }} more
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <div class="section-headline margin-top-0 margin-bottom-25">
                        <h3>Highest Rated Freelancers</h3>
                        {{-- <a href="#" class="headline-link">View All</a> --}}
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="default-slick-carousel freelancers-container freelancers-grid-layout">
                        @foreach ($featured_freelancers as $freelancer)
                            <div class="freelancer">
                                <div class="freelancer-overview">
                                    <div class="freelancer-overview-inner">

                                        <span class="bookmark-icon"></span>

                                        <div class="freelancer-avatar">
                                            <div class="verified-badge"></div>
                                            <a href="#">
                                                <img src="{{ asset(is_null($freelancer->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$freelancer->avatar}") }}"
                                                    alt="">
                                            </a>
                                        </div>

                                        <div class="freelancer-name">
                                            <h4>
                                                <a href="#">
                                                    {{ ucwords($freelancer->full_name) }}
                                                    <img class="flag" src="{{ asset('_home/images/flags/gb.svg') }}"
                                                        alt="" title="United Kingdom" data-tippy-placement="top">
                                                </a>
                                            </h4>
                                            <span>UI/UX Designer</span>
                                        </div>

                                        <div class="freelancer-rating">
                                            <div class="star-rating" data-rating="5.0"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="freelancer-details">
                                    <div class="freelancer-details-list">
                                        <ul>
                                            @if($freelancer->country != null)
                                                <li>Location <strong><i class="icon-material-outline-location-on"></i> {{ $freelancer->country->name }}</strong></li>
                                            @endif
                                            {{-- <li>Rate <strong>$60 / hr</strong></li> --}}
                                            <li>Job Success <strong>{{ $freelancer->job_success }}%</strong></li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('account.profile', ['username' => $freelancer->username]) }}" class="button button-sliding-icon ripple-effect">View Profile <i
                                            class="icon-material-outline-arrow-right-alt"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="section white padding-top-65 padding-bottom-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <div class="section-headline centered margin-bottom-15">
                        <h3>
                            {{-- Great jobs are done here --}}
                            We have the best hands!
                        </h3>
                    </div>
                    <div class="section-headline margin-top-0 margin-bottom-35 d-none">
                        <h3>Popular Contest Categories</h3>
                        <a href="{{ route('contests.index') }}" class="headline-link">
                            View All
                        </a>
                    </div>

                    <div class="listings-container compact-list-layout margin-top-35">
                        <div class="row">
                            @foreach ($featured_contests as $contest)
                                <div class="col-sm-6 col-md-3">
                                    @include("contests.contest_box", ["contest" => $contest])
                                </div>
                            @endforeach
                        </div>
                        {{-- @foreach ($featured_contests as $contest)
                            @include("contests.contest_row", ["contest" => $contest])
                        @endforeach --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <div class="section-headline margin-top-0 margin-bottom-85 centered">
                        <h3>
                            {{-- Only the best freelance design --}}
                            Sit-back and relax…
                        </h3>
                        <p class="text-muted">
                            Here's why 100,000+ businesses have chosen {{ config('app.name') }}
                        </p>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="reasons-why-each d-flex mb-3">
                                <div class="mr-3">
                                    <span class="material-icons text-custom-primary">check_circle_outline</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h5>
                                        <strong>
                                            Save Money & Time
                                        </strong>
                                    </h5>
                                    <p class="text-muted">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia dignissimos saepe sed
                                        rem, facilis quaerat odit facere ipsum.
                                    </p>
                                </div>
                            </div>
                            <div class="reasons-why-each d-flex mb-3">
                                <div class="mr-3">
                                    <span class="material-icons text-custom-primary">check_circle_outline</span>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="{{ route('offers.freelancers.index') }}">
                                        <h5>
                                            <strong>
                                                More Creativity
                                            </strong>
                                        </h5>
                                    </a>
                                    <p class="text-muted">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corporis est odit iure
                                        aliquid fugit iste sequi quia facere adipisci nostrum dolore quo nihil officia dicta
                                        placeat in magnam, facilis ad.
                                    </p>
                                </div>
                            </div>
                            <div class="reasons-why-each d-flex mb-3">
                                <div class="mr-3">
                                    <span class="material-icons text-custom-primary">check_circle_outline</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h5>
                                        <strong>
                                            A world of design
                                        </strong>
                                    </h5>
                                    <p class="text-muted">
                                        Lorem ipsum dolor sit, amet cre adipisci nostrum dolore quo nihil officia dicta
                                        placeat in magnam, facilis ad.
                                    </p>
                                </div>
                            </div>
                            <div class="reasons-why-each d-flex mb-3">
                                <div class="mr-3">
                                    <span class="material-icons text-custom-primary">check_circle_outline</span>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="{{ route('terms') }}#money-back">
                                        <h5>
                                            <strong>
                                                Money back guarantee
                                            </strong>
                                        </h5>
                                    </a>
                                    <p class="text-muted">
                                        aliquid fugit iste sequi quia facere adipisci nostrum dolore quo nihil officia dicta
                                        placeat in magnam, facilis ad.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="home-testimonials-container owl-carousel owl-theme">
                                <div class="home-testimonials-each d-flex justify-content-end">
                                    <div>
                                        <p>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis, perferendis
                                            dolorum porro iusto asperiores totam molestias natus pariatur qui quaerat
                                        </p>
                                        <div class="home-testimonials-each-bottom">
                                            <img src="{{ asset('images/user-avatar-placeholder.png') }}" alt=""
                                                class="img-fluid">
                                            <div>
                                                <small>
                                                    - Johnson Rice
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="home-testimonials-each d-flex justify-content-end">
                                    <div>
                                        <p>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis, perferendis
                                            dolorum porro iusto asperiores totam molestias natus pariatur qui quaerat
                                        </p>
                                        <div class="home-testimonials-each-bottom">
                                            <div>
                                                <img src="{{ asset('images/user-avatar-placeholder.png') }}" alt=""
                                                    class="img-fluid">
                                            </div>
                                            <small>
                                                - Johnson Rice
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="home-testimonials-each d-flex justify-content-end">
                                    <div>
                                        <p>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis, perferendis
                                            dolorum porro iusto asperiores totam molestias natus pariatur qui quaerat
                                        </p>
                                        <div class="home-testimonials-each-bottom">
                                            <div>
                                                <img src="{{ asset('images/user-avatar-placeholder.png') }}" alt=""
                                                    class="img-fluid">
                                            </div>
                                            <small>
                                                - Johnson Rice
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="section margin-top-65 margin-bottom-65 d-none">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <div class="section-headline centered margin-top-0 margin-bottom-45">
                        <h3>Featured Cities</h3>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-list-layout-1.html" class="photo-box"
                        data-background-image="{{ asset('_home/images/featured-city-01.jpg') }}">
                        <div class="photo-box-content">
                            <h3>San Francisco</h3>
                            <span>376 Jobs</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-list-layout-full-page-map.html" class="photo-box"
                        data-background-image="{{ asset('_home/images/featured-city-02.jpg') }}">
                        <div class="photo-box-content">
                            <h3>New York</h3>
                            <span>645 Jobs</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-grid-layout-full-page.html" class="photo-box"
                        data-background-image="{{ asset('_home/images/featured-city-03.jpg') }}">
                        <div class="photo-box-content">
                            <h3>Los Angeles</h3>
                            <span>832 Jobs</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-list-layout-2.html" class="photo-box"
                        data-background-image="{{ asset('_home/images/featured-city-04.jpg') }}">
                        <div class="photo-box-content">
                            <h3>Miami</h3>
                            <span>513 Jobs</span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="section padding-top-60 padding-bottom-75 d-none">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <div class="section-headline centered margin-top-0 margin-bottom-35">
                        <h3>Membership Plans</h3>
                    </div>
                </div>


                <div class="col-xl-12">

                    <div class="billing-cycle-radios margin-bottom-70">
                        <div class="radio billed-monthly-radio">
                            <input id="radio-5" name="radio-payment-type" type="radio" checked>
                            <label for="radio-5"><span class="radio-label"></span> Billed Monthly</label>
                        </div>

                        <div class="radio billed-yearly-radio">
                            <input id="radio-6" name="radio-payment-type" type="radio">
                            <label for="radio-6"><span class="radio-label"></span> Billed Yearly <span
                                    class="small-label">Save 10%</span></label>
                        </div>
                    </div>

                    <div class="pricing-plans-container">

                        <div class="pricing-plan">
                            <h3>Basic Plan</h3>
                            <p class="margin-top-10">One time fee for one listing or task highlighted in search results.</p>
                            <div class="pricing-plan-label billed-monthly-label"><strong>$19</strong>/ monthly</div>
                            <div class="pricing-plan-label billed-yearly-label"><strong>$205</strong>/ yearly</div>
                            <div class="pricing-plan-features">
                                <strong>Features of Basic Plan</strong>
                                <ul>
                                    <li>1 Listing</li>
                                    <li>30 Days Visibility</li>
                                    <li>Highlighted in Search Results</li>
                                </ul>
                            </div>
                            <a href="pages-checkout-page.html" class="button full-width margin-top-20">Buy Now</a>
                        </div>

                        <div class="pricing-plan recommended">
                            <div class="recommended-badge">Recommended</div>
                            <h3>Standard Plan</h3>
                            <p class="margin-top-10">One time fee for one listing or task highlighted in search results.</p>
                            <div class="pricing-plan-label billed-monthly-label"><strong>$49</strong>/ monthly</div>
                            <div class="pricing-plan-label billed-yearly-label"><strong>$529</strong>/ yearly</div>
                            <div class="pricing-plan-features">
                                <strong>Features of Standard Plan</strong>
                                <ul>
                                    <li>5 Listings</li>
                                    <li>60 Days Visibility</li>
                                    <li>Highlighted in Search Results</li>
                                </ul>
                            </div>
                            <a href="pages-checkout-page.html" class="button full-width margin-top-20">Buy Now</a>
                        </div>

                        <div class="pricing-plan">
                            <h3>Extended Plan</h3>
                            <p class="margin-top-10">One time fee for one listing or task highlighted in search results.</p>
                            <div class="pricing-plan-label billed-monthly-label"><strong>$99</strong>/ monthly</div>
                            <div class="pricing-plan-label billed-yearly-label"><strong>$1069</strong>/ yearly</div>
                            <div class="pricing-plan-features">
                                <strong>Features of Extended Plan</strong>
                                <ul>
                                    <li>Unlimited Listings Listing</li>
                                    <li>90 Days Visibility</li>
                                    <li>Highlighted in Search Results</li>
                                </ul>
                            </div>
                            <a href="pages-checkout-page.html" class="button full-width margin-top-20">Buy Now</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script type="text/javascript">
        const show_how_it_works_video = $(".show-how-it-works-video")
        const how_it_works_video_container = $(".how-it-works-video-container")

        show_how_it_works_video.on('click', function() {
            how_it_works_video_container.fadeIn()
            how_it_works_video_container.css({
                display: 'flex'
            })
            document.getElementById('how-it-works-video').play()
        })

        $('.how-it-works-video-container-close').find('span').on('click', function() {
            document.getElementById('how-it-works-video').pause()
            how_it_works_video_container.fadeOut()
        })

        $(document).ready(function() {
            $(".banner-right-w-carousel").owlCarousel({
                items: 1,
                loop: true,
                // transitionStyle : "fade",
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
            })

            $(".home-testimonials-container").owlCarousel({
                items: 1,
                loop: true,
                margin: 50,
                dots: true,
                autoplay: true
            })
        })
    </script>
@endsection
