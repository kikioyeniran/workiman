@extends('layouts.app')

@section('page_title', $offer->title)

@section('page_styles')
    <style type="text/css">
        .contests-banner {
            background-image: url("{{ asset('images/banners/1.png') }}");
            margin-bottom: 20px;
        }

        .contests-banner-inner {
            background-color: transparent;
            color: black !important;
        }

        @media (min-width: 1367px) {
            .container {
                max-width: 1210px;
            }
        }

    </style>
@endsection

@section('page_content')

    <div class="single-page-header" data-background-image="{{ asset('images/banners/1.png') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image">
                                <a href="single-company-profile.html">
                                    {{-- <img src="{{ asset(is_null($offer->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$offer->user->avatar}") }}"
                                        alt=""> --}}
                                    <img src="{{ asset($file_location.$offer->sub_category->picture) }}" alt="">
                                </a>
                            </div>
                            <div class="header-details">
                                <h3>
                                    {{ $offer->title }}
                                </h3>
                                <h5>
                                    {{ $offer->sub_category->offer_category->title }}
                                </h5>
                                <ul>
                                    <li>
                                        <a>
                                            <i class="icon-material-outline-mouse text-custom-primary"></i>
                                            @if ($offer->minimum_designer_level == 0)
                                                Any designer can apply
                                            @else
                                                Only designers with minimum of {{ $offer->minimum_designer_level }} can
                                                apply
                                            @endif
                                        </a>
                                    </li>
                                    {{-- <li><div class="star-rating" data-rating="4.9"></div></li>
								<li><img class="flag" src="images/flags/gb.html" alt=""> United Kingdom</li>
								<li><div class="verified-badge-with-title">Verified</div></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="right-side">
                            <div class="salary-box">
                                <div class="salary-type">
                                    Budget
                                </div>
                                <div class="salary-amount">
                                    {{-- {{ $offer->currency == 'dollar' ? '$' : '₦' }}{{ number_format($offer->price) }} --}}
                                    {{ $user_currency == 'dollar' ? '$' : '₦' }}{{ number_format(intval(getUserCurrencyAmount($user_currency, $offer->price, $offer->currency, $dollar_rate))) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div class="row">

            <!-- Content -->
            <div class="col-xl-8 col-lg-8 content-right-offset">

                <div class="single-page-section">
                    @include('layouts.section-header', ['header' => 'Offer Description'])
                    <p>
                        {{ $offer->description }}
                    </p>
                </div>

                <div class="single-page-section d-none">
                    <h3 class="margin-bottom-30">
                        Attachments
                    </h3>
                    {{-- <div id="single-job-map-container">
					<div id="singleListingMap" data-latitude="51.507717" data-longitude="-0.131095" data-map-icon="im im-icon-Hamburger"></div>
					<a href="#" id="streetView">Street View</a>
				</div> --}}
                </div>

                <hr class="mb-5">
                @if(auth()->check() && $offer->user_id == auth()->user()->id)
                    <div class="single-page-section">
                        @include('layouts.section-header', ['header' => 'Offer Interests'])
                    </div>

                    @if ($offer->interests->count())
                        <div class="freelancers-container freelancers-grid-layout margin-top-35 row">
                            @foreach ($offer->valid_interests as $interest)
                                <div class="mb-3 col-sm-6">
                                    @include('offers.project-manager.interested-freelancer-box', ['interest' => $interest,
                                    'offer' => $offer])
                                </div>

                                <div id="interest{{ $interest->id }}ProposalModal"
                                    class="zoom-anim-dialog mfp-hide dialog-with-tabs dialog">
                                    <!--Tabs -->
                                    <div class="sign-in-form">

                                        <ul class="popup-tabs-nav">
                                            <li><a href="#tab">Proposal</a></li>
                                        </ul>

                                        <div class="popup-tabs-container">
                                            <!-- Tab -->
                                            <div class="popup-tab-content" id="tab">

                                                {!! $interest->proposal !!}

                                            </div>
                                            <div style="width: 70% !important;" class="mr-auto ml-auto">
                                                <a href="{{ route('account.conversations', ['username' => $interest->user->username]) }}"
                                                    class="apply-now-button btn-custom-outline-primary margin-bottom-10"
                                                    style="background-color: transparent;color: var(--primary-color)">
                                                    Message {{ $interest->user->display_name }} <i class=" icon-feather-message-square"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <small>
                                You have no interested project managers in this offer.
                            </small>
                        </div>
                    @endif
                @endif
                <div class="single-page-section">
                    <h3 class="margin-bottom-25">Other offers like this</h3>

                    <!-- Listings Container -->
                    <div class="listings-container grid-layout">

                        @foreach ($related_offers as $related_offer)
                            <a href="{{ route('offers.freelancers.show', ['offer_slug' => $related_offer->slug]) }}"
                                class="job-listing">
                                <!-- Job Listing Details -->
                                <div class="job-listing-details">
                                    <div class="job-listing-description">
                                        <h4 class="job-listing-company">
                                            {{ $related_offer->sub_category->title }}
                                        </h4>
                                        <h3 class="job-listing-title">
                                            {{ $related_offer->title }}
                                        </h3>
                                    </div>
                                </div>

                                <!-- Job Listing Footer -->
                                <div class="job-listing-footer">
                                    <ul>
                                        {{-- <li><i class="icon-material-outline-location-on"></i> San Francisco</li>
                                    <li><i class="icon-material-outline-business-center"></i> Full Time</li> --}}
                                        <li><i class="icon-material-outline-account-balance-wallet"></i>
                                            {{-- ${{ number_format($related_offer->price) }} --}}
                                            {{ $user_currency == 'dollar' ? '$' : '₦' }}{{ number_format(intval(getUserCurrencyAmount($user_currency, $related_offer->price, $related_offer->currency, $dollar_rate))) }}
                                        </li>
                                        {{-- <li><i class="icon-material-outline-access-time"></i> 2 days ago</li> --}}
                                    </ul>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <!-- Listings Container / End -->

                </div>
            </div>


            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">

                    @if (auth()->check())
                        @if($offer->hasDispute == true && $offer->dispute->resolved == true || $offer->hasDispute == false)
                            @if (auth()->user()->id != $offer->user_id)
                                @if($offer->hasValidInterest(auth()->user()->id))
                                    <a href="#" class="apply-now-button margin-bottom-10" style="background-color: #28a745">
                                        Interest Submitted <i class="icon-material-outline-star"></i>
                                    </a>
                                @else
                                    <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim margin-bottom-10">
                                        Take this offer <i class="icon-material-outline-star"></i>
                                    </a>
                                @endif

                                @if (!auth()->user()->freelancer)
                                    <a href="{{ route('account.conversations', ['username' => $offer->user->username]) }}"
                                        class="apply-now-button btn-custom-outline-primary margin-bottom-10"
                                        style="background-color: transparent;color: var(--primary-color)">
                                        Message {{ $offer->user->display_name }} <i class=" icon-feather-message-square"></i>
                                    </a>
                                @endif

                                <a href="{{ route('account.profile', ['username' => $offer->user->username]) }}"
                                    class="apply-now-button btn-custom-outline-primary">
                                    View Profile <i class=" icon-feather-user"></i>
                                </a>
                            @else
                                <a href="{{ route('offers.freelancer.edit', $offer->id) }}" class="apply-now-button">
                                    Edit
                                    <i class=" icon-feather-edit"></i>
                                </a>
                            @endif
                        @else
                            <a href="#" class="apply-now-button btn btn-lg btn-danger" style="background-color: #dc3545">
                                Offer on Hold <i class="icon-material-outline-star"></i>
                            </a>
                        @endif
                    @else
                        <a href="#account-login-popup" id="account-login-popup-trigger"
                            class="apply-now-button popup-with-zoom-anim">
                            Sign in to join <i class="icon-material-outline-star"></i>
                        </a>
                    @endif

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget d-none">
                        <div class="job-overview">
                            <div class="job-overview-headline">Job Summary</div>
                            <div class="job-overview-inner">
                                <ul>
                                    <li>
                                        <i class="icon-material-outline-location-on"></i>
                                        <span>Location</span>
                                        <h5>London, United Kingdom</h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-business-center"></i>
                                        <span>Job Type</span>
                                        <h5>Full Time</h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-local-atm"></i>
                                        <span>Salary</span>
                                        <h5>$35k - $38k</h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-access-time"></i>
                                        <span>Date Posted</span>
                                        <h5>2 days ago</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
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
                            <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url"
                                title="Copy to Clipboard" data-tippy-placement="top"><i
                                    class="icon-material-outline-file-copy"></i></button>
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-buttons margin-top-25">
                            <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                            <div class="share-buttons-content">
                                <span>Interesting? <strong>Share It!</strong></span>
                                <ul class="share-buttons-icons">
                                    <li><a href="#" data-button-color="#3b5998" title="Share on Facebook"
                                            data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
                                    <li><a href="#" data-button-color="#1da1f2" title="Share on Twitter"
                                            data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                    <li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus"
                                            data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
                                    <li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn"
                                            data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                        </div>

                        @if($offer->status == 'active' && auth()->check() && (!auth()->user()->admin || !auth()->user()->super_admin) && auth()->user()->id != $offer->user_id)
                            <div class="justify-content-center mt-3 ml-auto mr-auto">
                                <a href="#dispute-popup-{{ $offer->id }}" class="apply-now-button btn btn-lg popup-with-zoom-anim btn-danger" style="background-color: #dc3545"
                                    id="submit-to-contest-dialog-trigger">
                                    Report<i class="icon-material-outline-star"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

        <!--Tabs -->
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a href="#tab">Send your offer to {{ $offer->user->display_name }}</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Welcome Text -->
                    <div class="welcome-text d-none">
                        <h3>Send your offer to {{ $offer->user->display_name }}</h3>
                    </div>

                    <form action="{{ route('offers.freelancers.interest', ['offer' => $offer]) }}" method="POST"
                        id="offer-submissions-form" class=" mb-3" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="currency" id="currency" value="{{ $offer->currency }}" required />
                        <input type="hidden" name="offer_description">
                        <div class="submit-field">
                            <h5>Timeline</h5>
                            <select class="with-border tippy" name="timeline" data-placeholder="No of designers" required>
                                <option value="">-</option>
                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}">{{ $i }}
                                        day{{ $i == 1 ? '' : 's' }}</option>
                                @endfor
                            </select>
                            <div class="clearfix"></div>
                        </div>
                        <div class="submit-field">
                            <h5>Agreed Price in {{ $user_currency == 'dollar' ? '$' : '₦' }}</h5>
                            <input type="number" class="with-border tippy" min="{{ number_format(intval(getUserCurrencyAmount($user_currency, $offer->price, $offer->currency, $dollar_rate))) }}" value="{{ number_format(intval(getUserCurrencyAmount($user_currency, $offer->price, $offer->currency, $dollar_rate))) }}" name="price" required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>

                        <textarea id="" cols="30" rows="3"
                            class="form-control" placeholder="Describe your Proposal here" name="proposal" required></textarea>

                        <!-- Button -->
                        <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit">
                            Submit Now <i class="icon-material-outline-arrow-right-alt"></i>
                        </button>
                    </form>



                </div>

            </div>
        </div>
    </div>


    <div id="dispute-popup-{{ $offer->id }}" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a>Report {{ $offer->title }} Offer</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Form -->
                    <form method="post" action="{{ route('account.freelancer-offer.dispute') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="offer" value="{{ $offer->id }}">

                        {{-- <input class=" with-border default margin-bottom-20" name="title" placeholder="Category Title" value="{{ $sub_category->title }}" required />

                        <input type="number" class=" with-border default margin-bottom-20" name="base_amount" placeholder="Base Amount" value="{{ $sub_category->base_amount }}" required /> --}}

                        <Textarea class=" with-border default margin-bottom-20" name='comments' placeholder="Add Comments Here"></Textarea>
                        <!-- Button -->
                        <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save <i class="icon-material-outline-arrow-right-alt"></i></button>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        const contestSubmissionsDropzone = new Dropzone("#offer-submissions-form", {
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 5,
            uploadMultiple: true,
            paramName: 'files',
            acceptedFiles: 'image/*',
            maxFiles: 5,
            dictRemoveFileConfirmation: 'Are you sure you want to remove this file',
            dictDefaultMessage: '<h1 class="icon-feather-upload-cloud" style="color: orange;"></h1><p>Drop files here to upload!</p>'
        })

        contestSubmissionsDropzone.on('addedfile', (file) => {
            file.previewElement.addEventListener('click', () => {
                preview_image_modal.find('img').attr({
                    src: file.dataURL
                })
                preview_image_modal.modal('show')
            })
        })

        contestSubmissionsDropzone.on('totaluploadprogress', (progress) => {
            console.log('Progress: ', progress);
            // $('#upload-progress').attr({
            //     'aria-valuenow': progress
            // }).css({
            //     width: `${progress}%`
            // })
            // if(progress >= 100) {
            //     $('#upload-progress').removeClass('bg-warning').addClass('bg-success')
            // }
        })

        contestSubmissionsDropzone.on('queuecomplete', () => {
            console.log("All files have been uploaded successfully");
            // contestSubmissionsDropzone.reset()
            contestSubmissionsDropzone.removeAllFiles()
        })

        contestSubmissionsDropzone.on('error', (file, errorMessage, xhrError) => {
            console.log("Error occurred here: ", file, errorMessage, xhrError);
            Snackbar.show({
                text: errorMessage.message,
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 5000,
                textColor: '#fff',
                backgroundColor: '#721c24'
            });
            loading_container.hide()
        })

        contestSubmissionsDropzone.on('success', (file, successMessage, xhrError) => {
            console.log("Error occurred here: ", file, successMessage, xhrError);
            Snackbar.show({
                text: successMessage.message,
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 10000,
                textColor: '#fff',
                backgroundColor: '#28a745'
            });
            setTimeout(() => {
                // window.location.reload()
                window.location =
                    `{{ url('offers/payment/project-managers') }}/${successMessage.offer_id}`;
            }, 5000);
        })

        $('#offer-submissions-button').on('click', () => {
            // $('#upload-progress').attr({
            //     'aria-valuenow': 0
            // }).css({
            //     width: `0%`
            // }).removeClass('bg-warning').addClass('bg-success')
            loading_container.show()
            contestSubmissionsDropzone.processQueue()
        })

    </script>
@endsection
