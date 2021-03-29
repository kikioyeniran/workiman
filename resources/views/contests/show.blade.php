@extends('layouts.app')

@section('page_title', $contest->title)

@section('page_styles')
    <style>
        .each-contest-attachment {
            background-color: #fff;
            margin-bottom: 10px;
            box-shadow: 3px 3px 15px 10px rgba(0, 0, 0, .05);
            border-radius: 5px;
            padding: 5px 5px 5px 10px;
        }

    </style>
@endsection

@section('page_content')

    <div class="single-page-header" data-background-image="{{ asset('_home/images/single-job.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include("contests.contest_header", ["contest" => $contest])
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
                    <div class="boxed-list-headline mb-3">
                        <h3 class="mb-0">
                            <i class=" icon-line-awesome-ellipsis-h"></i>
                            Description
                        </h3>
                    </div>
                    <p>
                        {{ $contest->description }}
                    </p>
                </div>

                <div class="single-page-section">
                    <div class="boxed-list-headline mb-3">
                        <h3 class="mb-0">
                            <i class=" icon-feather-file"></i>
                            Attachments
                        </h3>
                    </div>
                    <div class="contest-attachments-container">
                        @foreach ($contest->files as $attachment_key => $attachment)
                            <div class="each-contest-attachment d-flex justify-content-between align-items-center">
                                <div class="">
                                    <small>
                                        Attachment File{{ $attachment_key ? " {$attachment_key}" : '' }}
                                        {{-- {{ $attachment->content }} --}}
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
                    {{-- <div id="single-job-map-container">
                        <div id="singleListingMap" data-latitude="51.507717" data-longitude="-0.131095"
                            data-map-icon="im im-icon-Hamburger"></div>
                        <a href="#" id="streetView">Street View</a>
                    </div> --}}
                </div>

                @if (!auth()->check() || auth()->user()->id != $contest->user_id)
                    <hr class="mb-5">

                    <div class="single-page-section">
                        <h3 class="margin-bottom-25">Other Active Contests in this Category</h3>

                        <!-- Listings Container -->
                        <div class="listings-container grid-layout">

                            @foreach ($similar_contests as $similar_contest)
                                <a href="{{ route('contests.show', ['slug' => $similar_contest->slug]) }}"
                                    class="job-listing">
                                    <div class="job-listing-details">
                                        <div class="job-listing-company-logo">
                                            <img src="{{ asset(is_null($similar_contest->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$similar_contest->user->avatar}") }}"
                                                alt="" style="max-height: 50px;">
                                        </div>
                                        <div class="job-listing-description">
                                            <div class="job-listing-company text-black-50">
                                                <small>
                                                    <small>
                                                        {{ $similar_contest->sub_category->contest_category->title }}
                                                    </small>
                                                </small>
                                            </div>
                                            <h3 class="job-listing-title">
                                                {{ $similar_contest->title }}
                                            </h3>
                                        </div>
                                    </div>

                                    <!-- Job Listing Footer -->
                                    <div class="job-listing-footer">
                                        <ul>
                                            <li class="d-none"><i class="icon-material-outline-location-on"></i> San
                                                Francisco
                                            </li>
                                            <li class="d-none"><i class="icon-material-outline-business-center"></i> Full
                                                Time
                                            </li>
                                            <li>
                                                <i class="icon-material-outline-local-atm"></i>
                                                ${{ number_format($similar_contest->first_place_prize) }}
                                            </li>
                                            <li>
                                                <i class="icon-line-awesome-clock-o"></i>
                                                <span>
                                                    {{ $similar_contest->payment->created_at->diffForHumans() }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>


            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">
                @if (is_null($contest->ends_at))
                    <div class="text-center mb-3">
                        <h3 class="text-danger">Inactive</h3>
                    </div>
                @elseif($contest->ends_at <= \Carbon\Carbon::now()) <div class="text-center mb-3">
                    <small>
                        Ended
                    </small>
                    <br>
                    <h3 class="text-danger mb-0">
                        {{ $contest->ends_at->diffForHumans() }}
                    </h3>
                    <small>
                        ({{ $contest->ends_at->isoFormat('LLLL') }})
                    </small>
                </div>
                    @if (auth()->check() && auth()->user()->id == $contest->user_id)
                        <a href="{{ route('contests.submissions', ['slug' => $contest->slug]) }}"
                            class="apply-now-button mb-3 bg-white text-dark">
                            View {{ $contest->submissions->count() }}
                            Submission{{ $contest->submissions->count() > 1 ? 's' : '' }} <i class="icon-feather-eye"></i>
                        </a>
                    @endif
                @else
                    <div class="text-center mb-3">
                        <small>
                            Ends in
                        </small>
                        <br>
                        <h3 class="text-success mb-0">
                            {{ $contest->ends_at->diffForHumans() }}
                        </h3>
                        <small>
                            ({{ $contest->ends_at->isoFormat('LLLL') }})
                        </small>
                    </div>
                    @if (auth()->check())
                        @if (auth()->user()->id != $contest->user_id)
                            <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim"
                                id="submit-to-contest-dialog-trigger">
                                Submit to this contest <i class="icon-material-outline-star"></i>
                            </a>
                        @else
                            {{-- <a href="javascript:void(0)" class="apply-now-button mb-3">
                                    Edit Contest <i class="icon-feather-edit"></i>
                                </a> --}}
                            <a href="{{ route('contests.submissions', ['slug' => $contest->slug]) }}"
                                class="apply-now-button mb-3 bg-white text-dark">
                                View {{ $contest->submissions->count() }}
                                Submission{{ $contest->submissions->count() > 1 ? 's' : '' }} <i
                                    class="icon-feather-eye"></i>
                            </a>
                        @endif
                    @else
                        <a href="#account-login-popup" id="account-login-popup-trigger"
                            class="apply-now-button popup-with-zoom-anim">
                            Sign in to join <i class="icon-material-outline-star"></i>
                        </a>
                    @endif
                @endif

                @include("contests.contest-info-panel", ["contest" => $contest])

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
                </div>

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

                    <form action="{{ route('contests.submit', ['slug' => $contest->slug]) }}" method="POST"
                        id="contest-submissions-form" class="dropzone mb-3" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="contest_id" id="contest_id" value="" required />
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
    {{-- <script src="{{ asset('js/contest-dropzone.js') }}?{{ time() }}"></script> --}}
    <script>
        const submit_to_contest_dialog = $("#small-dialog")
        const submit_to_contest_dialog_trigger = $("#submit-to-contest-dialog-trigger")

        $(document).on('ready', function() {
            // submit_to_contest_dialog_trigger.trigger('click')
        })

    </script>
@endsection
