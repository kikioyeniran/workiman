@extends('account.layouts.app')

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
                                    <a href="pages-checkout-page.html" class="button">Finish Payment</a>
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
    </div>
@endsection
