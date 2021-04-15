<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">

            <!-- Responsive Navigation Trigger -->
            <a href="#" class="dashboard-responsive-nav-trigger">
                <span class="hamburger hamburger--collapse">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </span>
                <span class="trigger-title">Dashboard Navigation</span>
            </a>

            <!-- Navigation -->
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">

                    {{-- <ul data-submenu-title="Start"> --}}
                    <ul>
                        <li class="{{ Route::currentRouteName() == 'account' ? 'active' : '' }}">
                            <a href="{{ route('account') }}">
                                <i class="icon-material-outline-dashboard"></i>
                                Dashboard
                            </a>
                        </li>
                        @if (auth()->user()->freelancer)
                            <li class="">
                                <a href="{{ route('account.wallet') }}">
                                    <i class="icon-line-awesome-cc-mastercard"></i>
                                    Wallet
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('account.profile') }}">
                                <i class="icon-feather-user"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('account.conversations') }}">
                                <i class=" icon-feather-message-square"></i>
                                Messages
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteName() == 'account.settings' ? 'active' : '' }}">
                            <a href="{{ route('account.settings') }}">
                                <i class="icon-material-outline-settings"></i>
                                Profile Settings
                            </a>
                        </li>

                        <li class="d-none">
                            <a href="#"><i class="icon-material-outline-business-center"></i> Browse</a>
                            <ul>
                                <li><a href="{{ route('contests.index') }}">Contests</a></li>
                                <li><a href="{{ route('offers.project-managers.index') }}">Project Manager Offers</a>
                                </li>
                                <li><a href="{{ route('offers.freelancers.index') }}">Freelancer Offers</a></li>
                            </ul>
                        </li>
                    </ul>


                    <ul data-submenu-title="Contests">
                        @if (auth()->user()->freelancer)
                            <li>
                                <a href="{{ route('contest.entries') }}">
                                    <i class="icon-material-outline-business-center"></i>
                                    My Contest Entries
                                    {{-- <span class="nav-tag">{{ auth()->user()->contests->count() }}</span> --}}
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('contests.user', ['username' => auth()->user()->username]) }}">
                                    <i class="icon-material-outline-business-center"></i>
                                    My Contests
                                    {{-- <span class="nav-tag">{{ auth()->user()->contests->count() }}</span> --}}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('contests.index') }}">
                                <i class="icon-material-outline-business-center"></i>
                                Browse Active Contests
                            </a>
                        </li>
                        {{-- <li>
                            <a href="javascript: void(0)">
                                <i class="icon-material-outline-business-center"></i>
                                My Entries
                            </a>
                        </li> --}}
                    </ul>

                    <ul data-submenu-title="Offers">
                        @if (auth()->user()->freelancer)
                            <li>
                                <a href="{{ route('offers.assigned', ['username' => $user->username]) }}">
                                    <i class="icon-material-outline-extension"></i>
                                    Offers assigned to me
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('offers.user', ['username' => $user->username]) }}">
                                <i class="icon-material-outline-extension"></i>
                                My Offers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('offers.new') }}">
                                <i class="icon-material-outline-extension"></i>
                                Create New Offer
                            </a>
                        </li>
                    </ul>

                    {{-- <ul data-submenu-title="Account"> --}}
                    <ul>
                        {{-- <li>
                            <a href="{{ route('account.profile') }}">
                                <i class="icon-feather-user"></i>
                                Profile
                            </a>
                        </li>
                        @if (auth()->user()->freelancer)
                            <li>
                                <a href="{{ route('account.wallet') }}">
                                    <i class="icon-line-awesome-cc-mastercard"></i>
                                    Wallet
                                </a>
                            </li>
                        @endif
                        <li class="{{ Route::currentRouteName() == 'account.settings' ? 'active' : '' }}">
                            <a href="{{ route('account.settings') }}">
                                <i class="icon-material-outline-settings"></i>
                                Settings
                            </a>
                        </li> --}}
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="icon-material-outline-power-settings-new"></i>
                                Logout
                            </a>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>
