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
    {{-- <div class="how-it-works-video-container">
        <div class="how-it-works-inner">
            <div class="how-it-works-video-container-close">
                <span class="material-icons">close</span>
            </div>
            <video id="how-it-works-video" src="{{ asset('video/intro.mp4') }}" controls></video>
        </div>
    </div> --}}

<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Contact</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="{{ route('index') }}">Home</a></li>
						{{-- <li><a href="#">Pages</a></li> --}}
						<li>Contact</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>




    <div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
        <div class="container">
            <div class="row">



                <div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2">

                    <section id="contact" class="margin-bottom-60">
                        <h3 class="headline margin-top-15 margin-bottom-35">Any questions? Feel free to contact us!</h3>

                        <form method="post" action={{ route('contact') }} autocomplete="on">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-with-icon-left">
                                        <input class="with-border" name="name" type="text" id="name" placeholder="Your Name" required />
                                        <i class="icon-material-outline-account-circle"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-with-icon-left">
                                        <input class="with-border" name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required />
                                        <i class="icon-material-outline-email"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-with-icon-left">
                                        <input class="with-border" name="phone" type="text" id="phone" placeholder="Phone Number" required />
                                        <i class="icon-feather-phone"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-with-icon-left">
                                        <input class="with-border" name="subject" type="text" id="subject" placeholder="Subject" required />
                                        <i class="icon-material-outline-assignment"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <textarea class="with-border" name="message" cols="40" rows="5" id="comments" placeholder="Message" spellcheck="true" required></textarea>
                            </div>

                            <input type="submit" class="submit button margin-top-15" id="submit" value="Submit Message" />

                        </form>
                    </section>

                </div>

                <div class="col-xl-12">
                    <div class="contact-location-info margin-bottom-50">
                        <div class="contact-address">
                            <ul>
                                <li class="contact-address-headline">Our Office</li>
                                <li>2 Oade Odanye, Harmony Enclave, Adeniyi Jones, Ikeja, Lagos</li>
                                <li>Phone +234 (906) 7982 964</li>
                                <li><a href="#"><span class="__cf_email__" data-cfemail="761b171f1a36130e171b061a135815191b">info@workiman.com</span></a></li>
                                <li><a href="#"><span class="__cf_email__" data-cfemail="761b171f1a36130e171b061a135815191b">support@workiman.com</span></a></li>
                                <li>
                                    <div class="freelancer-socials">
                                        <ul>
                                            <li><a href="https://web.facebook.com/wexircreatives" title="facebook" data-tippy-placement="top"><i class="icon-brand-facebook"></i></a></li>
                                            <li><a href="https://www.instagram.com/workimancreative/" title="instagram" data-tippy-placement="top"><i class="icon-brand-instagram"></i></a></li>
                                            <li><a href="https://www.linkedin.com/showcase/workiman" title="linkedin" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
                                            {{-- <li><a href="#" title="GitHub" data-tippy-placement="top"><i class="icon-brand-github"></i></a></li> --}}

                                        </ul>
                                    </div>
                                </li>
                            </ul>

                        </div>
                        <div id="single-job-map-container">
                            <div id="singleListingMap" data-latitude="37.777842" data-longitude="-122.391805" data-map-icon="im im-icon-Hamburger"></div>
                            <a href="#" id="streetView">Street View</a>
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
                loop: true
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
