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

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <img src="{{ asset('images/404_img.png') }}" class="img img-fluid" />
                    <h2 class="text-center mt-2 text-bold"><strong>We're sorry the page you request was not found 🙁 </strong></h2>

                    <p class="text-center">
                        Click <a href="{{ route('index') }}">Here</a> to continue browsing
                    </p>
                </div>
            </div>

        </div>
    </div>

@endsection
