<header id="header-container" class="fullwidth ">
    <div id="header">
        <div class="container">

            <div class="left-side">

                <div id="logo">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('logo/logo-icon.png') }}" alt="">
                    </a>
                </div>

                <nav id="navigation">
                    <ul id="responsive" class="home-nav-header">
                        @if(auth()->check() && !auth()->user()->super_admin)
                            @if (!auth()->check() || (auth()->check() && !auth()->user()->freelancer))
                                <li>
                                    <a href="{{ route('contests.create') }}"
                                        class="{{ Route::currentRouteName() == 'contests.create' ? 'current' : '' }} create-contest-btn">Create
                                        a contest</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('offers.new') }}"
                                    class="{{ Route::currentRouteName() == 'offers.new' ? 'current' : '' }}">New Offer</a>
                            </li>
                            @if (!auth()->check() || (auth()->check() && auth()->user()->freelancer))
                                <li>
                                    <a href="{{ route('contests.index') }}"
                                        class="{{ Route::currentRouteName() == 'contests.index' ? 'current' : '' }}">
                                        Browse Contests
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('offers.project-managers.index') }}"
                                        class="{{ Route::currentRouteName() == 'offers.project-managers.index' ? 'current' : '' }}">
                                        Project Manager Offers
                                    </a>
                                </li>
                            @endif
                            @if (!auth()->check() || (auth()->check() && !auth()->user()->freelancer))
                                <li>
                                    <a href="{{ route('offers.freelancers.index') }}"
                                        class="{{ Route::currentRouteName() == 'offers.freelancers.index' ? 'current' : '' }}">
                                        Freelancer Offers
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </nav>
                <div class="clearfix"></div>
            </div>


            <div class="right-side">
                @if (!auth()->check())
                    <div class="header-widget hide-on-mobiles">
                        <div class="header-notifications">
                            <div class="header-notifications-trigger">
                                <a href="#account-login-popup" id="account-login-popup-trigger"
                                    class="popup-with-zoom-anim"><i class="icon-feather-user"></i></a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="header-widget">
                        <div class="header-notifications">

                            <!-- Trigger -->
                            <div class="header-notifications-trigger">
                                <a href="#" class=""><i class="icon-feather-bell"></i><span id="notification-countss">{{ auth()->user()->notification_count }}</span></a>
                            </div>

                            <!-- Dropdown -->
                            <div class="header-notifications-dropdown">

                                <div class="header-notifications-headline">
                                    <h4>Notifications</h4>
                                    <button class="mark-as-read ripple-effect-dark" title="Mark all as read" data-tippy-placement="left">
                                        {{-- <i class="icon-feather-check-square"></i> --}}
                                    </button>
                                </div>

                                <div class="header-notifications-content">
                                    <div class="header-notifications-scroll" data-simplebar>
                                        <ul>
                                            @foreach (auth()->user()->new_offers as $offer)
                                                @php
                                                    $count++;
                                                @endphp
                                                <!-- Notification -->
                                                <li class="notifications-not-read">
                                                    <a href="{{ route('offers.project-managers.show', ['offer_slug' => $offer->slug]) }}">
                                                        <span class="notification-avatar status-offline"><img src="{{ asset(is_null($offer->user->avatar) ? 'images/user-avatar-placeholder.png' : 'storage/avatars/' . $offer->user->avatar) }}" alt=""></span>
                                                        <div class="notification-text">
                                                            <strong>{{ $offer->user->username }}</strong>
                                                            <p class="notification-msg-text">You have a <strong>new offer</strong> from {{ $offer->user->username }}...</p>
                                                            <span class="color">{{ $offer->updated_at->diffForHumans() }}</span>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach

                                            @foreach (auth()->user()->new_contests as $contest)
                                                @if($contest->status == 'active')
                                                    @php
                                                        $count++;
                                                    @endphp
                                                    <li class="notifications-not-read">
                                                        <a href="{{ route('contests.show', ['slug' => $contest->slug]) }}">
                                                            <span class="notification-avatar status-offline"><img src="{{ asset(is_null($contest->user->avatar) ? 'images/user-avatar-placeholder.png' : 'storage/avatars/' . $contest->user->avatar) }}" alt=""></span>
                                                            <div class="notification-text">
                                                                <strong>{{ $contest->user->username }}</strong>
                                                                <p class="notification-msg-text">{{ $contest->user->full_name }} created a <strong>new contest</strong>...</p>
                                                                <span class="color">{{ $contest->updated_at->diffForHumans() }}</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>

                                {{-- <a href="dashboard-messages.html" class="header-notifications-button ripple-effect button-sliding-icon">View All Messages<i class="icon-material-outline-arrow-right-alt"></i></a> --}}
                            </div>
                        </div>
                        <div class="header-notifications">
                            <div class="header-notifications-trigger">
                                <a href="{{ route('account.conversations') }}"><i class="icon-feather-mail"></i><span>{{ auth()->user()->unread_messages }}</span></a>
                            </div>

                            <!-- Dropdown -->
                            <div class="header-notifications-dropdown">

                                <div class="header-notifications-headline">
                                    <h4>Messages</h4>
                                    <button class="mark-as-read ripple-effect-dark" title="Mark all as read" data-tippy-placement="left">
                                    </button>
                                </div>

                                <div class="header-notifications-content">
                                    <div class="header-notifications-scroll" data-simplebar>
                                        <ul>
                                            <li class="notifications-not-read">
                                                <a href="{{ route('account.conversations') }}">
                                                    {{-- <span class="notification-avatar status-offline"><img src="{{ asset(is_null($offer->user->avatar) ? 'images/user-avatar-placeholder.png' : 'storage/avatars/' . $offer->user->avatar) }}" alt=""></span> --}}
                                                    <div class="notification-text">
                                                        <p class="notification-msg-text">You have <strong>{{ auth()->user()->unread_messages }}</strong> new messages...</p>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="header-notifications user-menu">
                            <div class="header-notifications-trigger">
                                <a href="#">
                                    <div class="user-avatar status-online"><img
                                            src="{{ asset(is_null(auth()->user()->avatar) ? 'images/user-avatar-placeholder.png' : 'storage/avatars/' . auth()->user()->avatar) }}"
                                            style="max-height: 45px" alt=""></div>
                                </a>
                            </div>

                            <div class="header-notifications-dropdown">

                                <div class="user-status">

                                    <div class="user-details">
                                        <div class="user-avatar status-online"><img
                                                src="{{ asset(is_null(auth()->user()->avatar) ? 'images/user-avatar-placeholder.png' : 'storage/avatars/' . auth()->user()->avatar) }}"
                                                style="max-height: 45px" alt=""></div>
                                        <div class="user-name">
                                            {{ ucwords(auth()->user()->full_name) }}
                                            <span>{{ auth()->user()->freelancer ? 'Freelancer' : 'Project Manager' }}</span>
                                        </div>
                                    </div>

                                    <div class="status-switch d-none" id="snackbar-user-status">
                                        <label class="user-online current-status">Online</label>
                                        <label class="user-invisible">Invisible</label>
                                        <span class="status-indicator" aria-hidden="true"></span>
                                    </div>
                                </div>

                                <ul class="user-menu-small-nav">
                                    <li><a href="{{ route('account') }}"><i
                                                class="icon-material-outline-dashboard"></i> Dashboard</a></li>
                                    <li><a href="{{ route('account.settings') }}"><i
                                                class="icon-material-outline-settings"></i> Settings</a></li>
                                    <li><a href="{{ route('logout') }}"><i
                                                class="icon-material-outline-power-settings-new"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <span class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </span>

            </div>
        </div>
    </div>

</header>
<div class="clearfix"></div>
