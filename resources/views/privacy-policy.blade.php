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




    <div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <div class="section-headline margin-top-0 margin-bottom-85 centered">
                        <strong><h1>
                            Privacy Policy
                        </h1></strong>
                        {{-- <p class="text-muted">
                            Here's why 100,000+ businesses have chosen {{ config('app.name') }}
                        </p> --}}
                    </div>
                </div>

                <div class="col-xl-12">
                    {{-- <div class="row">
                    </div> --}}
                    <div class="row terms">
                        <h3 class="text-uppercase text-center">Please read these term and policy carefully before using our service at Workiman</h3>
                        <p class="text-muted">
                            If there is any deviation from this user agreements and other policy set by Workiman by any users of this platform, then we shall commence a legal prevailance of the agreements.
                        </p>
                        <p class="text-muted">
                            This is a valid agreement between you, or your company using our service as the case may be and Workiman References in this Agreement to “You” or “Your” are references to you as a freelancer, project manager or your company.
                        </p>
                        <p class="text-muted">
                            By using our service (Workiman) you attest to agree with these terms and conditions.
                        </p>
                        <p class="text-muted">
                            By registering on our platform attest to agree with these terms and conditions
                        </p>
                        <p class="text-muted">
                            Upon registering on Workiman you must agree to register as either a freelancer or a project manager as it may apply in your case.
                        </p>
                        <br>
                        <h3 class="text-muted">Amendments to this Agreement
                        </h3>
                        <p class="text-muted">
                            We hold the right to amend this Agreement statements anytime at wish, we will update the correspondent amendment of the agreement publicly on our platform and also provide notification as regarding this. Any adjustment made will take effect immediately after published on Workiman platform
                        </p>
                        <h3 class="text-muted w-100">Term         </h3>

                        <p class="text-muted">
                            This term is due effective on the date on which You register on our platform until termination
                        </p>
                        <p class="text-muted">
                            We hold the right to use or display any of Your Content on Workiman;
                        </p>
                        <p class="text-muted">
                            We reserve the right to hold and deny your Content is capable of breaching Your obligations under this Agreement;
                        </p>
                        <h3 class="text-muted">Confidentiality</h3>
                        <p class="text-muted">
                            You must not (without a proper permition by the other party), disclose the other party’s Information or contacts.
                        </p>
                        <p class="text-muted">
                            Both parties (freelancers and project managers) shall ensure that non of the other parties information is disclosed by their agent(s).
                        </p>
                        <h3 class="text-muted w-100">Policy</h3>
                        <p class="text-muted">
                            These following set policy as amended must be followed for any project on our platform (Workiman)
                        </p>
                        <p class="text-muted">
                            Project brief and description:
                        </p>
                        <p class="text-muted">
                            Project managers are required to compile a proper and understanding project brief for freelancers while creating a new project in the brief section.
                        </p>
                        <p class="text-muted">
                            Every project posted by a project manager on Workiman must be either a contest or a one-on-one project. If there are other very important requirements for the project, the project manager must clearly specify e:g color, font, style…
                        </p>
                        <p class="text-muted">
                            Project manager agrees to select at least winning design (if the contest is a multiple winner project, project manager must select all the multiple winners) to complete a contest process or otherwise will be handled by Workiman admin as the case may be.
                        </p>
                        <p class="text-muted">
                            Expired (outdated) projects may be concluded by Workiman after several contacts to the project manager with no response or no reasonable response.
                        </p>
                        <p class="text-muted">
                            Project manager must be ready and conclude a paid project after a period 1month from the date of project expiration.
                        </p>
                        <h3 class="text-muted">Tagline and Adons:</h3>
                        <p class="text-muted">
                            Tags in this case are referred to as search keywords for project posted on our platform. Project may decide to use any correspondent search keywords as tags at wish to enable freelancers find their projects.
                        </p>
                        <p class="text-muted">
                            Secured payment; this means implies that project manager guarantees freelancers of awarding the project to at least a freelancer entry in case of contests
                        </p>
                        <p class="text-muted">
                            Urgent; The urgent adon implies that a particular project is been forced to end at an earlier time other than the initial 7days by default, this creates a fast turnaround from freelancers submitting entries.
                        </p>
                        <p class="text-muted">
                            Project budget/pricing are automatically set by the platform according to the project preferences selected and can only be altered by project manager only by increasing project budget and not decreasing. However, this payment must be successfully fully paid before a project manager’s project can go live
                        </p>
                        <p class="text-muted">
                            In a case where contest project is been elapsed without project manager selecting a winning entry and has not requested refund (if legible) within the set period of 1month we may conclude the project in accordance.
                        </p>
                        <p class="text-muted">
                            For a one freelancer project where project manager selected a secured payment project, project manager must award such freelancer as secured from the project creation only if there is a relevant entry by the freelancer to the project within the space of 1month.
                        </p>
                        <p class="text-muted">
                            Project manager(s) must review all entries carefully before taking final decision to selecting or awarding entry.
                        </p>

                        <p class="text-muted">
                            Project managers may request reasonable revisions on entries in accordance with the initial brief specifications until satisfaction within the space of 1month after project initiation
                        </p>
                        <p class="text-muted">
                            In the process of communication within any freelancer and project manager, no party should request or ask for the other party’s contact or in a way to lure either of the parties to directly or indirectly share contact as this may lead to total termination of account and user and may also affect any balance on such account at our discretion.
                        </p>

                        <h3 class="text-muted w-100">Refund Policy</h3>
                        <p class="text-muted">
                            Contest refunds request – Project managers are eligible of full project payment refund if:

                            <ul>
                                <li class="text-muted">request refund according to the set guiding of project refund on Workiman platform</li>
                                <li class="text-muted">the project has no winner selected yet</li>
                                <li class="text-muted">project manager did not guarantee project payment from project creation adonsc</li>
                                <li class="text-muted">request for refund is raised within 90days from the day of project creation.</li>
                            </ul>

                        </p>
                        <p class="text-muted">
                            N:B refund is excluding project handling, adon...
                        </p>
                        <p class="text-muted">
                            Project managers can request full refund including project handling fee, adons… only if:
                            <ul>
                                <li class="text-muted">
                                    no entries are made by any freelancer before the contest closing time
                                </li>
                                <li class="text-muted">
                                    no entry by freelancer(s) meets the requirement as described in the project brief
                                </li>
                                <li class="text-muted">
                                    no entries are made by any freelancer before the contest closing time
                                </li>
                                <li class="text-muted">
                                    no entries are made by any freelancer before the contest closing time
                                </li>
                            </ul>
                        </p>

                        <p class="text-muted">
                            <strong>Exceptions</strong>  - Notwithstanding the terms above, Client is not eligible for and will not receive any refund where:

                            <ul>
                                <li class="text-muted">The Project / Contest is Guaranteed and therefore ineligible for a refund; or</li>
                                <li class="text-muted">Client has already selected a Winning Work.</li>
                            </ul>
                        </p>

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
