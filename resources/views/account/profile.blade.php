@extends('layouts.app')

@section('page_styles')
    <style>
    </style>
@endsection

@section('page_content')
    <div class="single-page-header" data-background-image="{{ asset('images/banners/1.png') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image freelancer-avatar">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="">
                                @else
                                    <img src="{{ asset('_home/images/user-avatar-placeholder.png') }}" alt="">
                                @endif
                            </div>
                            <div class="header-details">
                                <h3>
                                    {{ $user->full_name }}
                                    <span><i class="fa fa-user"></i> {{ $user->username }}</span>
                                </h3>
                                <ul>
                                    <li><div class="star-rating" data-rating="5.0"></div></li>
                                    {{-- <li><img class="flag" src="{{ asset('_home/images/flags/de.svg') }}" alt=""> Germany</li> --}}
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
                    {{-- @if ($user->freelancer && (!auth()->check() || ($user->id != auth()->user()->id)))
                        <a class="btn btn-success btn-block text-uppercase text-white">Send me an offer <i class="icon-material-outline-arrow-right-alt"></i></a>
                    @endif --}}
                    @if (auth()->check() && !auth()->user()->freelancer && $user->freelancer)
                        <a href="{{ route('account.conversations', ['username' => $user->username]) }}"
                            class="apply-now-button btn-custom-outline-primary margin-bottom-10"
                            style="background-color: transparent;color: var(--primary-color)">
                            Send Message
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="{{ $user->about == '' ? 'd-none' : 'col-xl-6 col-lg-6'  }} content-right-offset profile-left">

                <div class="single-page-section">
                    <h3 class="margin-bottom-25 text-uppercase">About Me</h3>
                    <p>
                        {{ $user->about }}
                    </p>
                </div>

                <div class="single-page-section d-none">
                    <h3 class="margin-bottom-25 text-uppercase">My Offers</h3>

                    <div class="active-offers">
                        <div class="active-offers-list">
                            @php $i = 0; @endphp
                            @forelse ($user->project_manager_offers->take(3) as $key => $offer)
                                @include("offers.project-manager.project-manager-offer-row", ['offer' => $offer])
                                <div class="each-active-offer mb-3 d-none">
                                    <div class="each-active-offer-head" data-ind="{{ $i }}">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="p-2 px-3 each-active-offer-head-title text-uppercase" data-ind="{{ $i }}">
                                                    {{ $offer->title }}
                                                </div>
                                            </div>
                                            <div class="col-md-2 p-0" data-ind="{{ $i }}">
                                                <div class="py-2 px-0" data-ind="{{ $i }}">
                                                    {{ $offer->delivery_mode == 'continuous' ? 'Continuous' : 'One time' }}
                                                </div>
                                            </div>
                                            <div class="col-md-3" data-ind="{{ $i }}">
                                                <div class="each-active-offer-head-price text-center" data-ind="{{ $i }}">
                                                    ${{ number_format($offer->budget) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="each-active-offer-body px-3 py-2 offer-body-{{ $i }}">
                                        <div class="row">
                                            <div class="col-9">
                                                <p>
                                                    {{ $offer->description }}
                                                </p>
                                            </div>
                                            <div class="col-3 each-active-offer-body-right">
                                                <a href="{{ route("offers.project-managers.show", ["offer_slug" => $offer->slug]) }}" class="btn btn-custom-primary btn-block">View Offer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @empty
                                <div class="alert alert-info">
                                    <small>
                                        No offers
                                    </small>
                                </div>
                            @endforelse
                        </div>

                        <div class="text-center py-4">
                            <a href="{{ route('offers.user', ['username' => $user->username]) }}" class="btn btn-custom-outline-primary px-5 text-uppercase">
                                View All Offers
                            </a>
                        </div>
                    </div>
                </div>

                <div class="boxed-list margin-bottom-60 d-none">
                    <div class="boxed-list-headline">
                        <h3><i class="icon-material-outline-thumb-up"></i> Work History and Feedback</h3>
                    </div>
                    <ul class="boxed-list-ul">
                        <li>
                            <div class="boxed-list-item">
                                <!-- Content -->
                                <div class="item-content">
                                    <h4>Web, Database and API Developer <span>Rated as Freelancer</span></h4>
                                    <div class="item-details margin-top-10">
                                        <div class="star-rating" data-rating="5.0"></div>
                                        <div class="detail-item"><i class="icon-material-outline-date-range"></i> August 2018</div>
                                    </div>
                                    <div class="item-description">
                                        <p>Excellent programmer - fully carried out my project in a very professional manner. </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="boxed-list-item">
                                <!-- Content -->
                                <div class="item-content">
                                    <h4>WordPress Theme Installation <span>Rated as Freelancer</span></h4>
                                    <div class="item-details margin-top-10">
                                        <div class="star-rating" data-rating="5.0"></div>
                                        <div class="detail-item"><i class="icon-material-outline-date-range"></i> June 2018</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="boxed-list-item">
                                <!-- Content -->
                                <div class="item-content">
                                    <h4>Fix Python Selenium Code <span>Rated as Employer</span></h4>
                                    <div class="item-details margin-top-10">
                                        <div class="star-rating" data-rating="5.0"></div>
                                        <div class="detail-item"><i class="icon-material-outline-date-range"></i> May 2018</div>
                                    </div>
                                    <div class="item-description">
                                        <p>I was extremely impressed with the quality of work AND how quickly he got it done. He then offered to help with another side part of the project that we didn't even think about originally.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="boxed-list-item">
                                <!-- Content -->
                                <div class="item-content">
                                    <h4>PHP Core Website Fixes <span>Rated as Freelancer</span></h4>
                                    <div class="item-details margin-top-10">
                                        <div class="star-rating" data-rating="5.0"></div>
                                        <div class="detail-item"><i class="icon-material-outline-date-range"></i> May 2018</div>
                                    </div>
                                    <div class="item-description">
                                        <p>Awesome work, definitely will rehire. Poject was completed not only with the requirements, but on time, within our small budget.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- Pagination -->
                    <div class="clearfix"></div>
                    <div class="pagination-container margin-top-40 margin-bottom-10">
                        <nav class="pagination">
                            <ul>
                                <li><a href="#" class="ripple-effect current-page">1</a></li>
                                <li><a href="#" class="ripple-effect">2</a></li>
                                <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Pagination / End -->

                </div>

                <div class="boxed-list margin-bottom-60 d-none">
                    <div class="boxed-list-headline">
                        <h3><i class="icon-material-outline-business"></i> Employment History</h3>
                    </div>
                    <ul class="boxed-list-ul">
                        <li>
                            <div class="boxed-list-item">
                                <!-- Avatar -->
                                <div class="item-image">
                                    <img src="images/browse-companies-03.png" alt="">
                                </div>

                                <!-- Content -->
                                <div class="item-content">
                                    <h4>Development Team Leader</h4>
                                    <div class="item-details margin-top-7">
                                        <div class="detail-item"><a href="#"><i class="icon-material-outline-business"></i> Acodia</a></div>
                                        <div class="detail-item"><i class="icon-material-outline-date-range"></i> May 2018 - Present</div>
                                    </div>
                                    <div class="item-description">
                                        <p>Focus the team on the tasks at hand or the internal and external customer requirements.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="boxed-list-item">
                                <!-- Avatar -->
                                <div class="item-image">
                                    <img src="images/browse-companies-04.png" alt="">
                                </div>

                                <!-- Content -->
                                <div class="item-content">
                                    <h4><a href="#">Lead UX/UI Designer</a></h4>
                                    <div class="item-details margin-top-7">
                                        <div class="detail-item"><a href="#"><i class="icon-material-outline-business"></i> Acorta</a></div>
                                        <div class="detail-item"><i class="icon-material-outline-date-range"></i> April 2014 - May 2018</div>
                                    </div>
                                    <div class="item-description">
                                        <p>I designed and implemented 10+ custom web-based CRMs, workflow systems, payment solutions and mobile apps.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="{{ $user->about == '' ? 'col-xl-12 col-lg-12' : 'col-xl-6 col-lg-6'  }} profile-right">
                <div class="sidebar-container">

                    <!-- Profile Overview -->
                    <div class="profile-overview">
                        @if($user->freelancer)
                            <div class="overview-item">
                                <strong>{{ $user->freelancer_offers->count() }}</strong><small>Offers</small>
                            </div>
                            <div class="overview-item">
                                <strong>{{ $user->contest_submissions->count() }}</strong><small>Contest Submissions</small>
                            </div>
                            <div class="overview-item">
                                <strong>{{ $user->contest_submissions->where('completed', true)->where('position', true)->count() }}</strong><small>Contests Won</small>
                            </div>
                        @else
                            <div class="overview-item">
                                <strong>{{ $user->project_manager_offers->count() }}</strong><small>Offers</small>
                            </div>
                            <div class="overview-item">
                                <strong>{{ $user->contests->whereNull('ended_at')->count() }}</strong><small>Open Contests</small>
                            </div>
                            <div class="overview-item">
                                <strong>{{ $user->contests->whereNotNull('ended_at')->count() }}</strong><small>Completed Contests</small>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <!-- Button -->

                    {{-- <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim margin-bottom-50">Make an Offer <i class="icon-material-outline-arrow-right-alt"></i></a> --}}

                    @if($user->freelancer)
                        <!-- Freelancer Indicators -->
                        <div class="sidebar-widget mt-4 mb-4">
                            <div class="freelancer-indicators">

                                <!-- Indicator -->
                                <div class="indicator">
                                    <small class="text-uppercase">Job Success</small>
                                    <strong>{{ $user->job_success }}%</strong>
                                    <div class="indicator-bar" data-indicator-percentage="{{ (int)$user->job_success }}"><span></span></div>
                                </div>

                                <!-- Indicator -->
                                <div class="indicator">
                                    <small class="text-uppercase">Response Rate</small>
                                    <strong>{{ $user->response_rate }}%</strong>
                                    <div class="indicator-bar" data-indicator-percentage="{{ (int)$user->response_rate }}"><span></span></div>
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4">

                    @endif

                    @if ($user->freelancer)
                        <!-- Widget -->
                        <div class="sidebar-widget d-none">
                            <h3>Social Profiles</h3>
                            <div class="freelancer-socials margin-top-25">
                                <ul>
                                    <li><a href="#" title="Dribbble" data-tippy-placement="top"><i class="icon-brand-dribbble"></i></a></li>
                                    <li><a href="#" title="Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                    <li><a href="#" title="Behance" data-tippy-placement="top"><i class="icon-brand-behance"></i></a></li>
                                    <li><a href="#" title="GitHub" data-tippy-placement="top"><i class="icon-brand-github"></i></a></li>

                                </ul>
                            </div>
                        </div>

                        <!-- Widget -->
                        @if ($user->freelancer_profile)
                            <div class="sidebar-widget">
                                <h3>Skills</h3>
                                <div class="task-tags">
                                    @if($user->freelancer_profile->skills == "" || is_null($user->freelancer_profile->skills))
                                        <div class="alert alert-info">
                                            <small>
                                                No skills added
                                            </small>
                                        </div>
                                    @else
                                        @foreach (explode(",", $user->freelancer_profile->skills) as $skill)
                                            <span>{{ $skill }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="sidebar-widget">
                                <h3>Awards</h3>
                                <div class="task-tags">
                                    @if($user->freelancer_profile->awards == "" || is_null($user->freelancer_profile->awards))
                                        <div class="alert alert-info">
                                            <small>
                                                No awards added
                                            </small>
                                        </div>
                                    @else
                                        @foreach (explode(",", $user->freelancer_profile->awards) as $award)
                                            <span>{{ $award }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Widget -->
                        <div class="sidebar-widget d-none">
                            <h3>Attachments</h3>
                            <div class="attachments-container">
                                <a href="#" class="attachment-box ripple-effect"><span>Cover Letter</span><i>PDF</i></a>
                                <a href="#" class="attachment-box ripple-effect"><span>Contract</span><i>DOCX</i></a>
                            </div>
                        </div>
                    @endif

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget d-none">
                        <h3>Bookmark or Share</h3>

                        <!-- Bookmark Button -->
                        <button class="bookmark-button margin-bottom-25">
                            <span class="bookmark-icon"></span>
                            <span class="bookmark-text">Bookmark</span>
                            <span class="bookmarked-text">Bookmarked</span>
                        </button>

                        <!-- Copy URL -->
                        <div class="copy-url">
                            <input id="copy-url" type="text" value="" class="with-border">
                            <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="Copy to Clipboard" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-buttons margin-top-25">
                            <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                            <div class="share-buttons-content">
                                <span>Interesting? <strong>Share It!</strong></span>
                                <ul class="share-buttons-icons">
                                    <li><a href="#" data-button-color="#3b5998" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
                                    <li><a href="#" data-button-color="#1da1f2" title="Share on Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                    <li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus" data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
                                    <li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12">
                <div class="single-page-section">
                    <div class="boxed-list-headline">
                        <h3 class="mb-0">
                            <i class=" icon-material-outline-announcement"></i> My Offers
                        </h3>
                    </div>
                    <div class="active-offers">
                        <div class="active-offers-list">
                            @if ($user->freelancer && $user->freelancer_offers->count() > 0)
                                @foreach ($user->freelancer_offers->take(3) as $key => $offer)
                                    @include("offers.project-manager.project-manager-offer-row", ['offer' => $offer])
                                @endforeach
                            @elseif($user->project_manager_offers->count() > 0)
                                @foreach ($user->project_manager_offers->take(3) as $key => $offer)
                                    @include("offers.project-manager.project-manager-offer-row", ['offer' => $offer])
                                @endforeach
                            @else
                                <div class="alert alert-info margin-top-20">
                                    <small>
                                        No offers
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
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
