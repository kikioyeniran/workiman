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
				<h3 class="margin-bottom-25">
                    Offer Description
                </h3>
				<p>
                    {{ $offer->description }}
                </p>
			</div>

			<div class="single-page-section">
				<h3 class="margin-bottom-30">
                    Attachments
                </h3>
				{{-- <div id="single-job-map-container">
					<div id="singleListingMap" data-latitude="51.507717" data-longitude="-0.131095" data-map-icon="im im-icon-Hamburger"></div>
					<a href="#" id="streetView">Street View</a>
				</div> --}}
            </div>

            @if($similar_offers->count())
                <hr class="mb-5">

                <div class="single-page-section">
                    <h3 class="margin-bottom-25">Other offers like this</h3>

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

				<a href="#small-dialog" class="apply-now-button popup-with-zoom-anim">
                    Take this offer <i class="icon-material-outline-star"></i>
                </a>

				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
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
@endsection
