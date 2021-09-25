@extends('layouts.app')

@section("page_title", "{$contest_user->username}'s contests")

@section('page_styles')
    <style type="text/css">
        .contests-banner{
            background-image: url("{{ asset('images/banners/1.png') }}");
        }
        .contests-banner-inner {
            padding-top: 50px;
            padding-bottom: 30px;
            background: none;
        }
        .contest-user-card-avatar {
            height: 70px;
            max-width: 70px;
            margin-right: 10px;
            object-fit: contain;
        }
        .each-contest-user-count {
            margin-right: 30px;
            text-align: center;
        }

        .each-contest-user-count h6 {
            font-size: 10px;
            text-transform: uppercase;
        }
        @media (min-width: 1367px) {
            .container {
                max-width: 1210px;
            }
        }
    </style>
@endsection

@section('page_content')
    <div class="contests-banner mb-4">
        <div class="contests-banner-inner">
            <div class="container">
                <div class="contest-user-card d-flex align-items-center flex-wrap mb-4">
                    <div class="contest-user-card-avatar">
                        <img src="{{ asset(is_null($contest_user->avatar) ? ("images/user-avatar-placeholder.png") : ("storage/avatars/{$contest_user->avatar}")) }}" alt="" class="img-thumbnail">
                    </div>
                    <h3 class="text-dark mb-0">
                        {{ trim($contest_user->full_name) != '' ? $contest_user->full_name : $contest_user->username }}
                        @if (!$contest_user->freelancer)
                            <div style="font-size: small;color: #ddZ;">Project Manager</div>
                        @endif
                    </h3>
                </div>
                <div class="contest-user-counts d-flex align-items-center flex-wrap">
                    @if (!is_null($contest_user->country))
                        <div class="each-contest-user-count">
                            <h6 class="text-dark">
                                Location
                            </h6>
                            <h5 class="text-dark mb-0">
                                {{ $contest_user->country->name }}
                            </h5>
                        </div>
                    @endif
                    <div class="each-contest-user-count">
                        <h6 class="text-dark">
                            Contests
                        </h6>
                        <h5 class="text-dark mb-0">
                            {{ $contest_user->paid_contests->count() }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container pb-5">
        <div class="row">
            <div class="col-xl-3 col-lg-4 d-none">
                <div class="card card-default contest-user-card">
                    <div class="card-body">
                        <div class="contest-user-card-avatar">
                            <img src="{{ asset(is_null($contest_user->avatar) ? ("images/user-avatar-placeholder.png") : ("storage/avatars/{$contest_user->avatar}")) }}" alt="">
                        </div>
                        <h5 class="mt-3 text-center">
                            {{ $contest_user->full_name }}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 content-left-offset">

                <h3 class="page-title text-capitalize">
                   {{ $status != null ? $status : '' }} Contests
                </h3>

                <div class="notify-box margin-top-15 d-none">
                    <div class="switch-container">
                        <label class="switch"><input type="checkbox"><span class="switch-button"></span><span
                                class="switch-text">Turn on email alerts for this search</span></label>
                    </div>

                    <div class="sort-by">
                        <span>Sort by:</span>
                        <select class="selectpicker hide-tick">
                            <option>Relevance</option>
                            <option>Newest</option>
                            <option>Oldest</option>
                            <option>Random</option>
                        </select>
                    </div>
                </div>

                <div class="listings-container compact-list-layout margin-top-0">
                    @forelse ($contests as $contest)
                        @if($status != null)
                            @if($contest->status == $status)
                                @include("contests.contest_row", ["contest" => $contest])
                            @endif
                        @else
                            @include("contests.contest_row", ["contest" => $contest])
                        @endif

                    @empty
                        <div class="alert alert-info">
                            <small>
                                There are no {{ $status }} contests available at the moment.
                            </small>
                        </div>
                    @endforelse
                </div>

                <div class="mt-3">
                    {{ $contests->links() }}
                </div>

                <!-- Pagination -->
                <div class="row d-none">
                    <div class="col-md-12">
                        <!-- Pagination -->
                        <div class="pagination-container margin-top-60 margin-bottom-60">
                            <nav class="pagination">
                                <ul>
                                    <li class="pagination-arrow"><a href="#"><i
                                                class="icon-material-outline-keyboard-arrow-left"></i></a></li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#" class="current-page">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li class="pagination-arrow"><a href="#"><i
                                                class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Pagination / End -->

            </div>
        </div>
    </div>
@endsection

@section("page_scripts")
    <script type="text/javascript">
    </script>
@endsection
