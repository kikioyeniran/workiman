@extends('account.layouts.app')

@section('page_styles')
    <style>
        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        .dollar-before::before {
            content: '$';
        }

        .no-contest-container {
            padding: 50px 20px;
            flex-direction: column;
            align-items: center;
            display: flex;
            color: black;
        }

        .no-contest-container i {
            font-size: 40px;
            margin-bottom: 30px;
        }

        .browse-contests-card {
            background-color: white;
            box-shadow: 3px 3px 15px 1px rgba(0, 0, 0, 0.15) !important;
            border-radius: 5px;
        }

        .browse-contests-card-left img {
            max-height: 200px;
        }

    </style>
@endsection

@section('page_content')
    <div class="dashboard-headline margin-bottom-20">
        <h3>Hello, {{ $user->display_name }}!</h3>
        <span>We are glad to see you again!</span>

        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="#">Home</a></li>
                <li>Dashboard</li>
            </ul>
        </nav>
    </div>

    @if ($user->freelancer)
        <div class="fun-facts-container">
            <div class="fun-fact" data-fun-fact-color="#efa80f">
                <div class="fun-fact-text">
                    <span>Wallet Balance</span>
                    <h4 class="dollar-before" style="font-size: 25px;font-weight: 500">
                        {{ number_format($user->wallet_balance) }}
                    </h4>
                </div>
                <div class="fun-fact-icon"><i class=" icon-line-awesome-money"></i></div>
            </div>
            <div class="fun-fact" data-fun-fact-color="#b81b7f">
                <div class="fun-fact-text">
                    <span>Offers</span>
                    <h4>{{ $user->freelancer_offers->count() }}</h4>
                </div>
                <div class="fun-fact-icon"><i class="icon-material-outline-gavel"></i></div>
            </div>
            <div class="fun-fact" data-fun-fact-color="#36bd78">
                <div class="fun-fact-text">
                    <span>Contest Submissions</span>
                    <h4>{{ $user->contest_submissions->count() }}</h4>
                </div>
                <div class="fun-fact-icon">
                    <i class="icon-line-awesome-check"></i>
                </div>
            </div>

            <!-- Last one has to be hidden below 1600px, sorry :( -->
            <div class="fun-fact" data-fun-fact-color="#2a41e6">
                <div class="fun-fact-text">
                    <span>Contests Won</span>
                    <h4>
                        {{ $user->contest_submissions->where('completed', true)->where('position', true)->count() }}
                    </h4>
                </div>
                <div class="fun-fact-icon"><i class=" icon-line-awesome-trophy"></i></div>
            </div>
        </div>

        <hr class=" margin-top-20">

        @if ($user->contest_submissions->count() < 1)
            <div class="browse-contests-card d-block d-sm-flex">
                <div
                    class="browse-contests-card-right flex-grow-1 d-flex flex-column justify-content-center align-items-start px-4">
                    <h2 class="mb-2">
                        Enter your first contest
                    </h2>
                    <a href="{{ route('contests.index') }}" class="btn btn-custom-primary">
                        <small>
                            Click here to browse open contests
                        </small>
                    </a>
                </div>
                <div class="browse-contests-card-left">
                    <img src="{{ asset('images/illustrations/browse-contests.png') }}" alt="">
                </div>
            </div>
        @endif

        @if ($suggested_contests->count())
            <div class="row margin-top-20">
                <div class="col">
                    @include('layouts.section-header', ['header' => 'Here are some suggested contests'])
                    @forelse ($suggested_contests as $contest)
                        @include("contests.contest_row", ["contest" => $contest])
                    @empty
                        <div class="no-contest-container">
                            <i class=" icon-line-awesome-frown-o"></i>

                            <h3>
                                There are no suggested contests at the moment.
                            </h3>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

    @else
        <div class="fun-facts-container">
            <div class="fun-fact" data-fun-fact-color="#b81b7f">
                <div class="fun-fact-text">
                    <span>My Open Contests</span>
                    <h4>{{ $user->contests->count() }}</h4>
                </div>
                <div class="fun-fact-icon"><i class="icon-material-outline-gavel"></i></div>
            </div>
            <div class="fun-fact" data-fun-fact-color="#36bd78">
                <div class="fun-fact-text">
                    <span>My Completed Contests</span>
                    <h4>{{ 0 }}</h4>
                </div>
                <div class="fun-fact-icon">
                    <i class="icon-line-awesome-check"></i>
                </div>
            </div>
            <div class="fun-fact" data-fun-fact-color="#efa80f">
                <div class="fun-fact-text">
                    <span>Reviews</span>
                    <h4>{{ 0 }}</h4>
                </div>
                <div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
            </div>

            <!-- Last one has to be hidden below 1600px, sorry :( -->
            <div class="fun-fact" data-fun-fact-color="#2a41e6">
                <div class="fun-fact-text">
                    <span>This Month Views</span>
                    <h4>987</h4>
                </div>
                <div class="fun-fact-icon"><i class="icon-feather-trending-up"></i></div>
            </div>
        </div>
    @endif

    <div class="row d-none">
        <div class="col-xl-6">
            <div class="dashboard-box">
                <div class="headline">
                    <h3><i class="icon-material-outline-assignment"></i> My Recent Contests</h3>
                </div>
                <div class="content">
                    <ul class="dashboard-box-list">
                        @forelse ($user->contests->take(5) as $contest)
                            <li>
                                <div class="invoice-list-item">
                                    <strong>
                                        {{ $contest->title }}
                                    </strong>
                                    <ul>
                                        <li>
                                            <span class="paid">Open</span>
                                        </li>
                                        <li>
                                            Created: {{ $contest->created_at->diffForHumans() }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="buttons-to-right">
                                    @if (!$contest->payment()->exists())
                                        <a href="{{ route('contests.payment', ['contest' => $contest]) }}"
                                            class="button">Finish Payment</a>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <div class="alert alert-info">
                                <small>
                                    You have not created any contest yet.
                                </small>
                            </div>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            @if (!$user->freelancer)
                {{-- User is not yet freelancer --}}
                <div class="dashboard-box">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            Register as a freelancer to start making money from your designs.
                        </div>
                        <div class="">
                            <a href="#" class="btn btn-primary">
                                Get started now!
                            </a>
                        </div>
                    </div>
                </div>
            @else

            @endif
        </div>
    </div>
@endsection

@section('page_popups')
    <div class="modal fade" id="registerFreelancerModal" tabindex="-1" role="dialog"
        aria-labelledby="registerFreelancerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerFreelancerModalLabel">
                        {{-- Complete your profile below to become a freelancer --}}
                        Become a freelancer
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="nationality" class="form-control" multiple="multiple">
                            <option value="">Skills</option>
                            <option value="photoshop">Photoshop</option>
                            <option value="photoshop">XD</option>
                            <option value="photoshop">Paint</option>
                            <option value="photoshop">Corel Draw</option>
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <select name="nationality" class="form-control">
                            <option value="">Select Nationality</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->citizenship }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class="form-group">
                        <input type="text" class="form-control" name="" id="">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Proceed</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script>
        // $('#registerFreelancerModal').modal('show')
        $('select').select2();
        $(document).ready(function() {});

    </script>
@endsection
