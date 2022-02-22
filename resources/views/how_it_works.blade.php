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
            <video id="how-it-works-video" src="{{ asset('video/how.mp4') }}" controls></video>
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
                                        {{-- Welcome to <strong class="color">{{ config('app.name') }}</strong> --}}
                                        Home of <strong class="color">creative minds</strong>
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

                    {{-- <div class=" mt-3">
                        <button class="btn btn-default d-flex align-items-center show-how-it-works-video pl-0">
                            <span class="material-icons">play_circle_filled</span>
                            <span class="ml-1">How it works</span>
                        </button>
                    </div> --}}

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

                <div class="col-md-6">
                    <div class="banner-right-w-container">
                        <video width="320" height="240" style="width: 100%; height: 100%; border-radius: 8px" controls>
                            <source src="{{ asset('video/how.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="section">
        <div class="row justify-content-center pt-3 pb-2">

            <div class="col-lg-6">
                <div class="d-flex">
                    <img src="{{ asset('images/money_back.png') }}" alt="" class="img-fluid money_back_img">
                    <div class="card money_back justify-content-center">
                        <p class="text-uppercase text-center mb-0">
                            MONEY BACK GUARANTEED
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div class="row justify-content-center pb-4 mb-5 d-sm-none how owl-carousel owl-theme">
            <div class="col-lg-3">
                <div class="how_process text-center">
                    <h2>1</h2>
                    <div class="how_body justify-content-center">
                        <img src="{{ asset('images/3icon.png') }}" alt="" class="img-fluid how_img">
                        <p>Create custom project offer that fits your project for freelancers to bid on. You can schedule one-off payments or continuous offer payment</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="how_process text-center">
                    <h2>2</h2>
                    <div class="how_body justify-content-center">
                        <img src="{{ asset('images/1icon.png') }}" alt="" class="img-fluid how_img">
                        <p>Create custom project offer that fits your project for freelancers to bid on. You can schedule one-off payments or continuous offer payment</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="how_process text-center">
                    <h2>3</h2>
                    <div class="how_body justify-content-center">
                        <img src="{{ asset('images/2icon.png') }}" alt="" class="img-fluid how_img">
                        <p>Create custom project offer that fits your project for freelancers to bid on. You can schedule one-off payments or continuous offer payment</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center pb-4 mb-5 d-none d-lg-flex">
            <div class="col-lg-3">
                <div class="how_process text-center">
                    <h2>1</h2>
                    <div class="how_body justify-content-center">
                        <img src="{{ asset('images/3icon.png') }}" alt="" class="img-fluid how_img">
                        <p>Create custom project offer that fits your project for freelancers to bid on. You can schedule one-off payments or continuous offer payment</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="how_process text-center">
                    <h2>2</h2>
                    <div class="how_body justify-content-center">
                        <img src="{{ asset('images/1icon.png') }}" alt="" class="img-fluid how_img">
                        <p>Create custom project offer that fits your project for freelancers to bid on. You can schedule one-off payments or continuous offer payment</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="how_process text-center">
                    <h2>3</h2>
                    <div class="how_body justify-content-center">
                        <img src="{{ asset('images/2icon.png') }}" alt="" class="img-fluid how_img">
                        <p>Create custom project offer that fits your project for freelancers to bid on. You can schedule one-off payments or continuous offer payment</p>
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
                        <p class="faq-title">
                            {{-- Only the best freelance design --}}
                            Frequently Asked <span >Questions</span>
                        </p>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="row justify-content-center">
                        @foreach ($faqs as $faq)
                            <div class="col-lg-5">
                                <div class="reasons-why-each d-flex mb-3">
                                    <div class="mr-3">
                                        <span class="material-icons text-custom-primary">check_circle_outline</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5>
                                            <strong>
                                                {{ $faq->question }}
                                            </strong>
                                        </h5>
                                        <hr style=" width: 40%; margin-left: 0px">
                                        <p class="text-muted">
                                            {{ $faq->answer }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                autoplay:true,
                autoplayTimeout: 3000,
                autoplayHoverPause:true
            })

            $(".home-testimonials-container").owlCarousel({
                items: 1,
                loop: true,
                margin: 50,
                dots: true,
                autoplay: true
            })

            $(".how").owlCarousel({
                items: 1,
                loop: true,
                margin: 50,
                dots: true,
                autoplay: true
            })


        })
    </script>
@endsection
