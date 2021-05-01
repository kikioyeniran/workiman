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

    </style>
@endsection

@section('page_content')
    <!-- add class "disable-gradient" to enable consistent background overlay -->
    <div class="intro-banner" data-background-image="{{ asset('_home/images/home-background.jpg') }}">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="banner-headline">
                        <h3>
                            <strong>
                                Welcome to <strong class="color">{{ config('app.name') }}</strong>
                            </strong>
                            <br>
                            <span>
                                Browse through our top skilled freelancers and project managers.
                            </span>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('search') }}" method="get">
                        <div class="intro-banner-search-form margin-top-95">
                            <div class="intro-search-field with-autocomplete">
                                <label for="autocomplete-input" class="field-title ripple-effect">What do you need?</label>
                                <div class="input-with-icon">
                                    <input name="keyword" type="text" placeholder="Logo Design" required>
                                    <i class="icon-material-outline-location-on"></i>
                                </div>
                            </div>

                            <div class="intro-search-field">
                                <label for="intro-keywords" class="field-title ripple-effect d-none">What job you
                                    want?</label>
                                {{-- <input id="intro-keywords" type="text" placeholder="Job Title or Keywords"> --}}
                                <select name="category" required>
                                    <option value=""></option>
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
    </div>

    <div class="section white padding-top-65">
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

    <div class="section white padding-top-65 padding-bottom-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <div class="section-headline margin-top-0 margin-bottom-35">
                        <h3>Featured Contests</h3>
                        <a href="{{ route('contests.index') }}" class="headline-link">
                            View All
                        </a>
                    </div>

                    <div class="listings-container compact-list-layout margin-top-35">
                        @foreach ($featured_contests as $contest)
                            @include("contests.contest_row", ["contest" => $contest])
                        @endforeach
                        <a href="single-job-page.html" class="job-listing with-apply-button d-none">

                            <div class="job-listing-details">

                                <div class="job-listing-company-logo">
                                    <img src="{{ asset('_home/images/company-logo-01.png') }}" alt="">
                                </div>

                                <div class="job-listing-description">
                                    <h3 class="job-listing-title">Bilingual Event Support Specialist</h3>

                                    <div class="job-listing-footer">
                                        <ul>
                                            <li><i class="icon-material-outline-business"></i> Hexagon <div
                                                    class="verified-badge" title="Verified Employer"
                                                    data-tippy-placement="top"></div>
                                            </li>
                                            <li><i class="icon-material-outline-location-on"></i> San Francissco</li>
                                            <li><i class="icon-material-outline-business-center"></i> Full Time</li>
                                            <li><i class="icon-material-outline-access-time"></i> 2 days ago</li>
                                        </ul>
                                    </div>
                                </div>

                                <span class="list-apply-button ripple-effect">Apply Now</span>
                            </div>
                        </a>
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
                                            <li>Location <strong><i class="icon-material-outline-location-on"></i>
                                                    London</strong></li>
                                            <li>Rate <strong>$60 / hr</strong></li>
                                            <li>Job Success <strong>95%</strong></li>
                                        </ul>
                                    </div>
                                    <a href="#" class="button button-sliding-icon ripple-effect">View Profile <i
                                            class="icon-material-outline-arrow-right-alt"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
    </script>
@endsection
