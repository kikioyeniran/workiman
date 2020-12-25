@extends('account.layouts.app')

@section('page_styles')
    <style>
        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }
   </style>
@endsection

@section('page_content')
    <div class="dashboard-headline">
        <h3>Hello, {{ $user->username }}!</h3>
        <span>We are glad to see you again!</span>

        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="#">Home</a></li>
                <li>Dashboard</li>
            </ul>
        </nav>
    </div>

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

    <div class="row">
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
                                        <a href="{{ route("contest.payment", ["contest" => $contest]) }}" class="button">Finish Payment</a>
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
    <div class="modal fade" id="registerFreelancerModal" tabindex="-1" role="dialog" aria-labelledby="registerFreelancerModalLabel" aria-hidden="true">
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
        $(document).ready(function() {
        });
    </script>
@endsection
