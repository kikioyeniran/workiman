@extends('layouts.app')

@section('page_title', $offer->title)

@section('page_styles')
    <style>
        .each-contest-attachment {
            background-color: #fff;
            margin-bottom: 10px;
            box-shadow: 3px 3px 15px 10px rgba(0, 0, 0, .05);
            border-radius: 5px;
            padding: 5px 5px 5px 10px;
        }

        #show-interest-button {
            cursor: pointer;
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
                                    <img src="{{ asset(is_null($offer->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$offer->user->avatar}") }}"
                                        alt="">
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
                                    {{ $offer->currency == 'dollar' ? "$" : '₦' }}{{ number_format(intval(getCurrencyAmount($offer->currency, $offer->budget, $offer->currency))) }}
                                    {{-- ${{ number_format($offer->budget) }} --}}
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
                    <h3 class="margin-bottom-10">
                        Interested Freelancers
                    </h3>

                    @if ($offer->interests->count())
                        <div class="freelancers-container freelancers-grid-layout margin-top-35 row">
                            @foreach ($offer->interests as $interest)
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

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <small>
                                You have no interested freelancers in this offer.
                            </small>
                        </div>
                    @endif
                </div>
            </div>


            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">

                    <a href="{{ route('offers.project-managers.show', ['offer_slug' => $offer->slug]) }}"
                        class="apply-now-button my-3">
                        <i class="icon-feather-arrow-left"></i>
                        Back to Offer
                    </a>

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <div class="job-overview">
                            <div class="job-overview-headline">Job Summary</div>
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
                                                Only designers with minimum of {{ $offer->minimum_designer_level }} can
                                                apply
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
                                        <span>Timeline</span>
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

                </div>
            </div>

        </div>
    </div>

@endsection

@section('page_scripts')
    <script>
        const assign_freelancer = $(".assign-freelancer")

        assign_freelancer.on('click', function() {
            let selected_interest = $(this).data('interest')

            console.log(selected_interest)

            loading_container.show()

            fetch(`${webRoot}offers/assign-freelancer/{{ $offer->id }}`, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        _token,
                        interest: selected_interest,
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
