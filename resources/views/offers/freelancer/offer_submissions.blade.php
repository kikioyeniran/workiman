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
                                            Interest Shown by <strong> {{ $interest->user->fullname }}</strong>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="right-side">
                            <div class="salary-box">
                                <div class="salary-type">
                                    Amount Paid
                                </div>
                                @if($interest->is_paid == true)
                                    <div class="salary-amount">
                                        {{ $user_currency == 'dollar' ? '$' : '₦' }}{{ number_format(intval(getUserCurrencyAmount($user_currency, $interest->price, $offer->currency, $dollar_rate))) }}
                                    </div>
                                @else
                                    <div class="salary-amount">
                                        {{ $user_currency == 'dollar' ? '$' : '₦' }}{{ number_format(intval(getUserCurrencyAmount($user_currency, 0, $offer->currency, $dollar_rate))) }}
                                    </div>
                                @endif
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
                    @include('layouts.section-header', ['header' => 'Interest Description'])
                    <p>
                        {{ $interest->proposal }}
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
                {{-- @if(auth()->check() && $offer->user_id == auth()->user()->id)
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
                @endif --}}
                @if (auth()->check() && $interest->submissions->count())
                    @include("layouts.section-header", ["header" => 'Submissions', 'icon' => 'icon-feather-box'])

                    @foreach ($interest->submissions as $submission)
                        <div class="contest-submission-card">
                            <div class="row">
                                <div class="contest-submission-card-left col-md-8 col-lg-9">
                                    <div class="d-flex">
                                        <small class="mr-3 text-secondary">
                                            #{{ $submission->reference }}
                                        </small>
                                        <h6>
                                            <i class="icon-feather-user"></i>
                                            {{ $interest->user->username }}
                                        </h6>
                                    </div>
                                    <div class="contest-submission-card-thumbnails">
                                        @foreach ($submission->files as $submission_file)
                                            <img src="{{ asset($file_location.$submission_file->content) }}"
                                                data-id="{{ $submission->id }}" data-file="{{ $submission_file->id }}"
                                                data-username="{{ $submission->user->username }}" alt=""
                                                class="img-fluid img-thumbnail submission-thumbnail"
                                                data-comments="{{ $submission_file->comments }}">
                                        @endforeach
                                    </div>
                                </div>
                                <div
                                    class="contest-submission-card-left col-md-4 col-lg-3 flex-column justify-content-around text-right">
                                    <a class="btn btn-custom-outline-primary my-1 d-none"
                                        href="{{ route('offers.submission.download-files', ['offer' => $interest->freelancer_offer_id, 'submission' => $submission->id]) }}">
                                        <small>
                                            Download Files
                                            <i class="icon-feather-download"></i>
                                        </small>
                                    </a>
                                    <a class="btn btn-custom-outline-primary my-1"
                                        href="{{ route('offers.submission.show', ['interest' => $interest->id, 'submission' => $submission->id]) }}">
                                        {{-- href="#"> --}}
                                        <small>
                                            View
                                            <i class=" icon-feather-arrow-right"></i>
                                        </small>
                                    </a>
                                    {{-- @if (!is_null($submission->description))
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- <div class="single-page-section">
                    @include('layouts.section-header', ['header' => 'Attachments'])
                    <div class="contest-attachments-container">
                        @foreach ($offer->files as $attachment_key => $attachment)
                            <div class="each-contest-attachment d-flex justify-content-between align-items-center">
                                <div class="">
                                    <small>
                                        Attachment File{{ $attachment_key ? " {$attachment_key}" : '' }}

                                    </small>
                                </div>
                                <div>
                                    <a class="btn btn-sm btn-info"
                                        download="{{ "{$contest->slug}" . ($attachment_key ? "-{$attachment_key}" : '') }}"
                                        target="_blank"
                                        href="{{ asset("storage/contest-files/{$contest->id}/{$attachment->content}") }}">
                                        Download
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
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
                                <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim" id="submit-to-contest-dialog-trigger">
                                    Add Submission
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


                </div>
            </div>

        </div>
    </div>

    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

        <!--Tabs -->
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a href="#tab">Attach Submissions</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Welcome Text -->
                    <div class="welcome-text d-none">
                        <h3>Attach Submissions</h3>
                    </div>

                    <form action="{{ route('offers.interest.submit', ['interest' => $interest->id]) }}" method="POST"
                        id="contest-submissions-form" class="dropzone mb-3" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="interest_id" id="interest_id" value="{{ $interest->id }}" required />
                        <input type="hidden" name="description">

                    </form>

                    <textarea onkeyup="$('input[name=description]').val($(this).val())" id="" cols="30" rows="3"
                        class="form-control" placeholder="Describe your submission here"></textarea>

                    <!-- Button -->
                    <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                        form="apply-now-form" id="contest-submissions-button">
                        Submit Now <i class="icon-material-outline-arrow-right-alt"></i>
                    </button>

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

        const contestSubmissionsDropzone = new Dropzone("#contest-submissions-form", {
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
                window.location.reload()
            }, 5000);
        })

        $('#contest-submissions-button').on('click', () => {
            // $('#upload-progress').attr({
            //     'aria-valuenow': 0
            // }).css({
            //     width: `0%`
            // }).removeClass('bg-warning').addClass('bg-success')
            loading_container.show()
            contestSubmissionsDropzone.processQueue()
        })

    </script>

    <script>
        const submit_to_contest_dialog = $("#small-dialog")
        const submit_to_contest_dialog_trigger = $("#submit-to-contest-dialog-trigger")

        $(document).on('ready', function() {
            // submit_to_contest_dialog_trigger.trigger('click')
        })

    </script>

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
