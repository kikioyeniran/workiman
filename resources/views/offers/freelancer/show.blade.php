@extends('layouts.app')

@section('page_title', $offer->title)

@section('page_styles')

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
                                ${{ number_format($offer->price) }}
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

			<div class="single-page-section">
				<h3 class="margin-bottom-25">Other offers like this</h3>

				<!-- Listings Container -->
				<div class="listings-container grid-layout">

                    @foreach ($related_offers as $related_offer)
                        <a href="{{ route("offers.freelancers.show", ["offer_slug" => $related_offer->slug]) }}" class="job-listing">
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
                                    <li><i class="icon-material-outline-account-balance-wallet"></i> ${{ number_format($related_offer->price) }}</li>
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
                    @if (auth()->user()->id != $offer->user_id)
                        {{-- <a href="{{ route('offers.offer-freelancer', ['offer_slug' => $offer->slug]) }}" class="apply-now-button"> --}}
                        <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim">
                            Take this offer <i class="icon-material-outline-star"></i>
                        </a>
                    @else
                        <a href="javascript: void(0)" class="apply-now-button popup-with-zoom-anim">
                            Edit
                            <i class=" icon-feather-edit"></i>
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

                <form action="{{ route('offers.offer-freelancer', ['offer_slug' => $offer->slug]) }}" method="POST"
                    id="offer-submissions-form" class="dropzone mb-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="contest_id" id="contest_id" value="" required />
                    <input type="hidden" name="offer_description">

                </form>

                <textarea onkeyup="$('input[name=offer_description]').val($(this).val())" id="" cols="30" rows="3"
                    class="form-control" placeholder="Describe your offer here"></textarea>

                <!-- Button -->
                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                    form="apply-now-form" id="offer-submissions-button">
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
                window.location = `{{ url('offers/payment/project-managers') }}/${successMessage.offer_id}`;
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
