@extends('layouts.app')

@section('page_title', $offer->title)

@section('page_styles')
    <style>
        .each-contest-attachment {
            background-color: #fff;
            box-shadow: 3px 3px 15px 10px rgba(0, 0, 0, .05);
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 5px 5px 5px 10px;
        }
        #show-interest-button {
            cursor: pointer;
        }
        .interest-positive-box {
            background-color: #fff;
            box-shadow: 3px 3px 15px 10px rgba(0, 0, 0, .05);
            padding: 10px;
            border-left: 3px solid var(--primary-color);
            margin-bottom: 20px;
            text-align: center;
        }

        .each-comment-container {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .each-comment-container > div {
            background-color: #fff;
            box-shadow: 3px 3px 15px 10px rgba(0, 0, 0, .05);
            padding: 5px 10px;
            font-size: small;
            /* display: flex; */
            max-width: 80%;
            margin-bottom: 3px;
        }
        .each-comment-container.comment-left {
            align-items: flex-start;
        }
        .each-comment-container.comment-left > div {
            border-left: 3px solid var(--primary-color);
        }

        .each-comment-container.comment-right {
            align-items: flex-end;
        }
        .each-comment-container.comment-right > div {
            border-right: 3px solid var(--primary-color);
        }
        .each-comment-container small {
            font-size: x-small;
            color: #888;
        }

        .comment-content.files {
            display: flex;
            flex-wrap: wrap;
        }
        .comment-content.files > div {
            margin: 5px 5px;
        }
        .comment-content.files img {
            height: 50px;
            object-fit: contain;
        }
    </style>
@endsection

@section('page_content')

<div class="single-page-header" data-background-image="{{ asset('_home/images/single-job.jpg') }}">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-image">
                            <a href="single-company-profile.html">
                                <img src="{{ asset(is_null($offer->user->avatar) ? ("images/user-avatar-placeholder.png") : ("storage/avatars/{$offer->user->avatar}")) }}" alt="">
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
                                        @if($offer->minimum_designer_level == 0)
                                            Any designer can apply
                                        @else
                                            Only designers with minimum of {{ $offer->minimum_designer_level }} can apply
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
                                ${{ number_format($offer->budget) }}
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
				@include('layouts.section-header', ['header' => 'Description'])
				<p>
                    {{ $offer->description }}
                </p>
			</div>

			<div class="single-page-section">
				@include('layouts.section-header', ['header' => 'Attachments', 'icon' => 'icon-feather-file'])
                <div class="contest-attachments-container">
                    @foreach ($offer->files as $attachment_key => $attachment)
                        <div class="each-contest-attachment d-flex justify-content-between align-items-center">
                            <div class="">
                                <small>
                                    Attachment File{{ $attachment_key ? " {$attachment_key}" : '' }}
                                    {{-- {{ $attachment->content }} --}}
                                </small>
                            </div>
                            <div>
                                <a class="btn btn-sm btn-custom-primary"
                                    download="{{ "{$offer->slug}" . ($attachment_key ? "-{$attachment_key}" : '') }}"
                                    target="_blank"
                                    href="{{ asset("storage/offer-files/{$offer->id}/{$attachment->content}") }}">
                                    <small>
                                        Download
                                        <i class=" icon-feather-download"></i>
                                    </small>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if (auth()->check() && ((auth()->user()->id == $offer->user->id) || $offer->interests->where('assigned', true)->where('user_id', auth()->user()->id)->first()))
                @include('layouts.section-header', ['header' => 'Comments', 'icon' => 'icon-line-awesome-comments'])

                <div class="margin-top-20">
                    {{-- @forelse ($offer->comments->where('content_type', 'text') as $comment) --}}
                    @forelse ($offer->comments as $comment)
                        <div class="each-comment-container comment-{{ $comment->user_id == auth()->user()->id ? 'right' : 'left' }}">
                            {{-- <div> --}}
                                @if ($comment->content_type == 'text')
                                    <div class="comment-content">
                                        {{ $comment->content }}
                                    </div>
                                @elseif ($comment->content_type == 'image')
                                    <div class="comment-content files">
                                        @foreach (json_decode($comment->content) as $comment_file)
                                            <div>
                                                <img src="{{ asset("storage/offer-comment-images/{$comment->offer->id}/{$comment_file}") }}" alt="" class="img-thumbnail comment-file">
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($comment->content_type == 'file')
                                    <div class="comment-content files">
                                        <a href="{{ route("offers.project-managers.download-file", ["comment" => $comment->id]) }}" class="btn btn-custom-primary">
                                            Download Files
                                            <i class=" icon-feather-download-cloud"></i>
                                        </a>
                                        {{-- @foreach (json_decode($comment->content) as $comment_file)
                                            <div>
                                                <img src="{{ asset("storage/offer-comment-files/{$comment->offer->id}/{$comment_file}") }}" alt="" class="img-thumbnail comment-file">
                                            </div>
                                        @endforeach --}}
                                    </div>
                                @endif
                                <small>
                                    {{ $comment->user->display_name }}
                                </small>
                            {{-- </div> --}}
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <small>
                                Comments unavailable.
                            </small>
                        </div>
                    @endforelse
                </div>

                <hr>

                @if (!$offer->completed)
                    <div class="text-center">
                        <a class="btn btn-custom-primary popup-with-zoom-anim px-4" href="#comment-dialog">
                            Add Comment
                            <i class=" icon-line-awesome-comment"></i>
                        </a>
                        <a class="btn btn-custom-outline-primary popup-with-zoom-anim px-4" href="#upload-image-dialog">
                            Image
                            <i class=" icon-feather-upload"></i>
                        </a>
                        @if (auth()->user()->id != $offer->user->id)
                            <a class="btn btn-custom-primary popup-with-zoom-anim px-4" href="#upload-file-dialog">
                                Upload Raw Files
                                <i class=" icon-line-awesome-cloud-upload"></i>
                            </a>
                        @endif
                    </div>
                @endif
            @elseif ($offer->interests->where('assigned', true)->count() < 1 && $offer->comments->where('user_id', $offer->user_id)->count())
                @include('layouts.section-header', ['header' => 'Comments', 'icon' => 'icon-line-awesome-comments'])

                <div class="margin-top-20">
                    {{-- @forelse ($offer->comments->where('content_type', 'text') as $comment) --}}
                    @foreach ($offer->comments->where('user_id', $offer->user_id) as $comment)
                        <div class="each-comment-container comment-left">
                            {{-- <div> --}}
                                @if ($comment->content_type == 'text')
                                    <div class="comment-content">
                                        {{ $comment->content }}
                                    </div>
                                @elseif ($comment->content_type == 'image')
                                    <div class="comment-content files">
                                        @foreach (json_decode($comment->content) as $comment_file)
                                            <div>
                                                <img src="{{ asset("storage/offer-comment-images/{$comment->offer->id}/{$comment_file}") }}" alt="" class="img-thumbnail comment-file">
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($comment->content_type == 'file')
                                    <div class="comment-content files">
                                        <a href="{{ route("offers.project-managers.download-file", ["comment" => $comment->id]) }}" class="btn btn-custom-primary">
                                            Download Files
                                            <i class=" icon-feather-download-cloud"></i>
                                        </a>
                                        {{-- @foreach (json_decode($comment->content) as $comment_file)
                                            <div>
                                                <img src="{{ asset("storage/offer-comment-files/{$comment->offer->id}/{$comment_file}") }}" alt="" class="img-thumbnail comment-file">
                                            </div>
                                        @endforeach --}}
                                    </div>
                                @endif
                                <small>
                                    {{ $comment->user->display_name }}
                                </small>
                            {{-- </div> --}}
                        </div>
                    @endforeach
                </div>
            @endif
		</div>


		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">

                @if (auth()->check())
                {{-- {{ $offer->user_id }}
                {{ auth()->user()->id }} --}}
                    @if (auth()->user()->id != $offer->user_id)
                        @if ($offer->completed)
                            <div class="interest-positive-box">
                                <small>
                                    Offer Completed Successfully
                                    <i class=" icon-feather-check-circle text-success"></i>
                                </small>
                            </div>
                        @elseif ($offer->interests->where('user_id', auth()->user()->id)->count() < 1)
                            <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim text-white">
                                Show Interest <i class="icon-material-outline-star"></i>
                            </a>
                        @elseif($offer->interests->where('user_id', auth()->user()->id)->where('assigned', true)->count())
                            <div class="interest-positive-box">
                                <small>
                                    Offer Assigned
                                    <i class="text-info icon-feather-check-circle"></i>
                                </small>
                            </div>
                        @elseif($offer->interests->where('user_id', auth()->user()->id)->count())
                            <div class="interest-positive-box">
                                <small>
                                    Interest Saved
                                </small>
                            </div>
                        @endif
                    @else
                        {{-- <a href="javascript:void(0)" class="apply-now-button mb-3">
                                Edit Contest <i class="icon-feather-edit"></i>
                            </a> --}}
                        @if($assigned_interest = $offer->interests->where('assigned', true)->first())
                            @if ($offer->completed)
                                <div class="interest-positive-box">
                                    <small>
                                        Offer Completed Successfully
                                        <i class=" icon-feather-check-circle text-success"></i>
                                    </small>
                                </div>
                            @else
                                <div class="mb-3">
                                    <a href="javascript: void(0)" class="btn btn-custom-outline-primary btn-block py-3" data-toggle="modal" data-target="#markAsCompletedModal">
                                        Mark as Completed
                                        <i class=" icon-feather-check-circle"></i>
                                    </a>
                                </div>
                            @endif
                            <div class="mb-3">
                                @include('offers.project-manager.interested-freelancer-box', ['interest' => $assigned_interest, 'offer' => $offer])
                            </div>
                        @else
                            <a href="{{ route('offers.project-managers.interested-freelancers', ['offer_slug' => $offer->slug]) }}"
                                class="apply-now-button mb-3 bg-white text-dark">
                                <small>
                                    View {{ $offer->interests->count() }}
                                Interested Freelancer{{ $offer->interests->count() > 1 ? 's' : '' }} <i
                                    class="icon-feather-eye"></i>
                                </small>
                            </a>
                        @endif
                    @endif
                @else
                    <a href="#account-login-popup" id="account-login-popup-trigger"
                        class="apply-now-button popup-with-zoom-anim">
                        Sign in to join <i class="icon-material-outline-star"></i>
                    </a>
                @endif

				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<div class="job-overview">
						<div class="job-overview-headline">Offer Summary</div>
						<div class="job-overview-inner">
							<ul>
								<li>
									{{-- <i class="icon-material-outline-location-on"></i> --}}
                                    <i class="icon-line-awesome-star"></i>
                                    @if ($offer->minimum_designer_level == 0)
                                        <span>
                                            Any designer can apply
                                        </span>
                                    @else
                                        <span>
                                            Only designers with minimum of {{ $offer->minimum_designer_level }} can apply
                                        </span>
                                    @endif
								</li>
								<li>
									<i class="icon-material-outline-business-center"></i>
									<span>Job Type</span>
									<h5>
                                        {{ $offer->delivery_mode == 'continuous' ? 'Continuous' : 'One time' }}
                                    </h5>
								</li>
								<li>
									<i class=" icon-feather-calendar"></i>
									<span>Tineline</span>
									<h5>
                                        {{ $offer->timeline }} day{{ $offer->timeline > 1 ? 's' : '' }}
                                    </h5>
								</li>
								<li>
									<i class="icon-material-outline-access-time"></i>
									<span>Date Posted</span>
									<h5>
                                        {{ $offer->created_at->diffForHumans() }}
                                    </h5>
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

	</div>

    <div class="row mt-5">
        <div class="col-xl-8 col-lg-8 content-right-offset">
            @if($similar_offers->count())
                {{-- <hr class="mb-5"> --}}

                <div class="single-page-section">
                    @include('layouts.section-header', ['header' => 'Other Similar Offers', 'icon' => 'icon-feather-align-justify'])

                    <!-- Listings Container -->
                    <div class="listings-container grid-layout">

                        @foreach ($similar_offers as $similar_offer)
                            <a href="{{ route('offers.project-managers.show', ['offer_slug' => $similar_offer->slug]) }}"
                                class="job-listing">
                                <div class="job-listing-details">
                                    <div class="job-listing-company-logo">
                                        <img src="{{ asset(is_null($similar_offer->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$similar_offer->user->avatar}") }}"
                                            alt="" style="max-height: 50px;">
                                    </div>
                                    <div class="job-listing-description">
                                        <div class="job-listing-company text-black-50">
                                            <small>
                                                <small>
                                                    {{ $similar_offer->sub_category->offer_category->title }}
                                                </small>
                                            </small>
                                        </div>
                                        <h3 class="job-listing-title">
                                            {{ $similar_offer->title }}
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
                                            ${{ number_format($similar_offer->first_place_prize) }}
                                        </li>
                                        <li>
                                            <i class="icon-line-awesome-clock-o"></i>
                                            <span>
                                                {{-- {{ $similar_offer->payment->created_at->diffForHumans() }} --}}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <!-- Listings Container / End -->

                </div>
            @endif
        </div>

        <div class="col-xl-4 col-lg-4 content-right-offset">
        </div>
    </div>
</div>

<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab">Show Interest</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <div class="form-group">
                    <input type="number" name="price" id="" placeholder="How much will you charge for this offer?">
                </div>

                <div class="form-group">
                    <input type="number" name="timeline" id="" placeholder="How many days?">
                </div>

                <div class="form-group">
                    <textarea name="proposal" id="" placeholder="Enter a short proposal." rows="2"></textarea>
                </div>

                <!-- Button -->
                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                    form="apply-now-form" id="show-interest-button">
                    Submit Now <i class="icon-material-outline-arrow-right-alt"></i>
                </button>

            </div>

        </div>
    </div>
</div>

<div id="comment-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs dialog">
    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab">Add Comment</a></li>
        </ul>

        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <div class="form-group">
                    <textarea name="comment" id="" placeholder="Enter comment here?"></textarea>
                </div>

                <!-- Button -->
                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect"
                    form="apply-now-form" id="add-comment-button">
                    Send <i class="icon-material-outline-arrow-right-alt"></i>
                </button>

            </div>

        </div>
    </div>
</div>

<div id="upload-image-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs dialog">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab">Upload Images</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Welcome Text -->
                <div class="welcome-text d-none">
                    <h3>Upload Images</h3>
                </div>

                <form action="{{ route('offers.project-managers.comment', ['offer' => $offer->id]) }}" method="POST"
                    id="upload-image-form" class="dropzone mb-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="contest_id" id="contest_id" value="" required />

                </form>
{{--
                <textarea onkeyup="$('input[name=description]').val($(this).val())" id="" cols="30" rows=""
                    class="form-control" placeholder="Describe your submission here"></textarea> --}}

                <!-- Button -->
                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                    form="apply-now-form" id="upload-image-button">
                    Submit Now <i class="icon-material-outline-arrow-right-alt"></i>
                </button>

            </div>

        </div>
    </div>
</div>

<div id="upload-file-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs dialog">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab">Upload Files</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Welcome Text -->
                <div class="welcome-text d-none">
                    <h3>Upload Files</h3>
                </div>

                <form action="{{ route('offers.project-managers.comment', ['offer' => $offer->id]) }}" method="POST"
                    id="upload-file-form" class="dropzone mb-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="contest_id" id="contest_id" value="" required />

                </form>
                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                    form="apply-now-form" id="upload-file-button">
                    Submit Now <i class="icon-material-outline-arrow-right-alt"></i>
                </button>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="commentFileModal" tabindex="-1" aria-labelledby="commentFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="" alt="" style="max-height: 75vh">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="markAsCompletedModal" tabindex="-1" aria-labelledby="markAsCompletedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="markAsCompletedModalLabel">Are you sure you want to mark as completed?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-5">
                <i class="icon-feather-info text-warning" style="font-size: 40px;"></i>
                <h3 class="text-center mt-3">
                    You cannot undo this action
                </h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Return</button>
                <button type="button" class="btn btn-custom-primary mark-as-completed-button">
                    <i class=" icon-feather-check"></i>
                    Yes, Continue
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section("page_scripts")
    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        const offerImageDropzone = new Dropzone("#upload-image-form", {
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 5,
            uploadMultiple: true,
            paramName: 'images',
            acceptedFiles: 'image/*',
            maxFiles: 5,
            dictRemoveFileConfirmation: 'Are you sure you want to remove this file',
            dictDefaultMessage: '<h1 class="icon-feather-upload-cloud" style="color: orange;"></h1><p>Drop files here to upload!</p>'
        })

        offerImageDropzone.on('addedfile', (file) => {
            file.previewElement.addEventListener('click', () => {
                preview_image_modal.find('img').attr({
                    src: file.dataURL
                })
                preview_image_modal.modal('show')
            })
        })

        offerImageDropzone.on('totaluploadprogress', (progress) => {
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

        offerImageDropzone.on('queuecomplete', () => {
            console.log("All files have been uploaded successfully");
            // offerImageDropzone.reset()
            offerImageDropzone.removeAllFiles()
        })

        offerImageDropzone.on('error', (file, errorMessage, xhrError) => {
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

        offerImageDropzone.on('success', (file, successMessage, xhrError) => {
            console.log("Error occurred here: ", file, successMessage, xhrError);
            Snackbar.show({
                text: "Uploaded successfully.",
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

        $('#upload-image-button').on('click', () => {
            // $('#upload-progress').attr({
            //     'aria-valuenow': 0
            // }).css({
            //     width: `0%`
            // }).removeClass('bg-warning').addClass('bg-success')
            if (offerImageDropzone.getQueuedFiles() < 1) {
                Snackbar.show({
                    text: "You need to add at least 1 file for submission.",
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }
            loading_container.show()
            offerImageDropzone.processQueue()
        })

        const offerFileDropzone = new Dropzone("#upload-file-form", {
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 5,
            uploadMultiple: true,
            paramName: 'files',
            // acceptedFiles: 'image/*',
            maxFiles: 5,
            dictRemoveFileConfirmation: 'Are you sure you want to remove this file',
            dictDefaultMessage: '<h1 class="icon-feather-upload-cloud" style="color: orange;"></h1><p>Drop files here to upload!</p>'
        })

        offerFileDropzone.on('addedfile', (file) => {
            file.previewElement.addEventListener('click', () => {
                preview_image_modal.find('img').attr({
                    src: file.dataURL
                })
                preview_image_modal.modal('show')
            })
        })

        offerFileDropzone.on('totaluploadprogress', (progress) => {
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

        offerFileDropzone.on('queuecomplete', () => {
            console.log("All files have been uploaded successfully");
            // offerFileDropzone.reset()
            offerFileDropzone.removeAllFiles()
        })

        offerFileDropzone.on('error', (file, errorMessage, xhrError) => {
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

        offerFileDropzone.on('success', (file, successMessage, xhrError) => {
            console.log("Error occurred here: ", file, successMessage, xhrError);
            Snackbar.show({
                text: "Uploaded successfully.",
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

        $('#upload-file-button').on('click', () => {
            // $('#upload-progress').attr({
            //     'aria-valuenow': 0
            // }).css({
            //     width: `0%`
            // }).removeClass('bg-warning').addClass('bg-success')
            if (offerFileDropzone.getQueuedFiles() < 1) {
                Snackbar.show({
                    text: "You need to add at least 1 file for submission.",
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }
            loading_container.show()
            offerFileDropzone.processQueue()
        })

    </script>
    <script>
        const show_interest_button = $("#show-interest-button")
        const add_comment_button = $("#add-comment-button")

        show_interest_button.on('click', function() {
            // loading_container.show();

            let price_input = $("input[name=price]")
            let timeline_input = $("input[name=timeline]")
            let proposal_input = $("textarea[name=proposal]")

            if (price_input.val().trim() == "") {
                Snackbar.show({
                    text: "Please enter a valid amount.",
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }

            if (timeline_input.val().trim() == "") {
                Snackbar.show({
                    text: "Please enter a valid number of days.",
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }

            if (proposal_input.val().trim() == "") {
                Snackbar.show({
                    text: "Please enter a proposal.",
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }

            // console.log(timeline_input.val())
            // return
            loading_container.show()

            fetch(`${webRoot}offers/interest/project-managers/{{ $offer->id }}`, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        _token,
                        price: price_input.val(),
                        timeline: timeline_input.val(),
                        proposal: proposal_input.val(),
                    })
                }).then(response => response.json())
                .then(async responseJson => {
                    if (responseJson.success) {
                        // console.log("Success here", responseJson);
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: 'green'
                        });
                        setTimeout(() => {
                            // loading_container.hide();
                            window.location.reload();
                        }, 2000)
                    } else {
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#721c24'
                        });
                        loading_container.hide();
                    }
                })
                .catch(error => {
                    console.log("Error occurred: ", error);
                    Snackbar.show({
                        text: `Error occurred, please try again`,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                })
        })

        add_comment_button.on('click', function() {
            // loading_container.show();

            let comment_input = $("textarea[name=comment]")

            if (comment_input.val().trim() == "") {
                Snackbar.show({
                    text: "Please enter a valid comment.",
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }

            // console.log(comment_input.val())
            // return
            loading_container.show()

            fetch(`${webRoot}offers/comment/project-managers/{{ $offer->id }}`, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        _token,
                        comment: comment_input.val(),
                    })
                }).then(response => response.json())
                .then(async responseJson => {
                    if (responseJson.success) {
                        // console.log("Success here", responseJson);
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: 'green'
                        });
                        setTimeout(() => {
                            // loading_container.hide();
                            window.location.reload();
                        }, 2000)
                    } else {
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#721c24'
                        });
                        loading_container.hide();
                    }
                })
                .catch(error => {
                    console.log("Error occurred: ", error);
                    Snackbar.show({
                        text: `Error occurred, please try again`,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                })
        })

        $(".comment-file").on('click', function(e) {
            let src = $(e.target).attr('src')

            $("#commentFileModal").find('img').attr({src: src})
            $("#commentFileModal").modal('show')
        })
    </script>
    <script>
        const mark_as_completed_button = $(".mark-as-completed-button")

        mark_as_completed_button.on('click', function() {
            loading_container.show()

            fetch(`${webRoot}offers/completed/project-managers/{{ $offer->id }}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                }).then(response => response.json())
                .then(async responseJson => {
                    if (responseJson.success) {
                        // console.log("Success here", responseJson);
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: 'green'
                        });
                        setTimeout(() => {
                            // loading_container.hide();
                            window.location.reload();
                        }, 2000)
                    } else {
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#721c24'
                        });
                        loading_container.hide();
                    }
                })
                .catch(error => {
                    console.log("Error occurred: ", error);
                    Snackbar.show({
                        text: `Error occurred, please try again`,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                })
        })
    </script>
@endsection
