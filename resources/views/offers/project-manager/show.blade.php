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
				<div class="boxed-list-headline mb-3">
                    <h3 class="mb-0">
                        <i class=" icon-line-awesome-ellipsis-h"></i>
                        Description
                    </h3>
                </div>
				<p>
                    {{ $offer->description }}
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

            @if($similar_offers->count())
                <hr class="mb-5">

                <div class="single-page-section">
                    <div class="boxed-list-headline mb-3">
                        <h3 class="mb-0">
                            <i class=" icon-feather-align-justify"></i>
                            Similar Offers
                        </h3>
                    </div>

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


		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">

                @if (auth()->check())
                {{-- {{ $offer->user_id }}
                {{ auth()->user()->id }} --}}
                    @if (auth()->user()->id != $offer->user_id)
                        @if ($offer->interests->where('user_id', auth()->user()->id)->count() < 1)
                            <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim text-white">
                                Show Interest <i class="icon-material-outline-star"></i>
                            </a>
                        @elseif($offer->interests->where('user_id', auth()->user()->id)->where('assigned', true)->count())
                            <div class="interest-positive-box">
                                <small>
                                    Offer Assigned
                                    <i class=" icon-feather-check-circle"></i>
                                </small>
                            </div>
                        @else
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

                <!-- Button -->
                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                    form="apply-now-form" id="show-interest-button">
                    Submit Now <i class="icon-material-outline-arrow-right-alt"></i>
                </button>

            </div>

        </div>
    </div>
</div>
@endsection

@section("page_scripts")
    <script>
        const show_interest_button = $("#show-interest-button")

        show_interest_button.on('click', function() {
            // loading_container.show();

            let price_input = $("input[name=price]")
            let timeline_input = $("input[name=timeline]")

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
    </script>
@endsection
