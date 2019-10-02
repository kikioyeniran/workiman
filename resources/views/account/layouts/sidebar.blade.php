<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">

            <!-- Responsive Navigation Trigger -->
            <a href="#" class="dashboard-responsive-nav-trigger">
                <span class="hamburger hamburger--collapse" >
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
                        <li class="">
                            <a href="#">
                                <i class="icon-material-outline-forum"></i>
                                Messages
                                <span class="nav-tag">0</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#">
                                <i class="icon-material-baseline-star-border"></i>
                                Bookmarks
                            </a>
                        </li>
                        <li class="">
                            <a href="#">
                                <i class="icon-material-outline-rate-review"></i>
                                Reviews
                            </a>
                        </li>
                    </ul>

                    <ul data-submenu-title="Contests">
                        <li>
                            <a href="javascript: void(0)">
                                <i class="icon-material-outline-business-center"></i>
                                My Contests
                                {{-- <span class="nav-tag">{{ auth()->user()->contests->count() }}</span> --}}
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0)">
                                <i class="icon-material-outline-business-center"></i>
                                Active Contests
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0)">
                                <i class="icon-material-outline-business-center"></i>
                                My Entries
                            </a>
                        </li>
                    </ul>

                    <ul data-submenu-title="Offers">
                        <li>
                            <a href="{{ route('offers.user', ['username' => $user->username]) }}">
                                <i class="icon-material-outline-extension"></i>
                                My Offers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('offers.create') }}">
                                <i class="icon-material-outline-extension"></i>
                                New Offer
                            </a>
                        </li>
                    </ul>

                    {{-- <ul data-submenu-title="Account"> --}}
                    <ul>
                        <li>
                            <a href="{{ route('account.profile') }}">
                                <i class="icon-feather-user"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-line-awesome-cc-mastercard"></i>
                                Wallet
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteName() == 'account.settings' ? 'active' : '' }}">
                            <a href="{{ route('account.settings') }}">
                                <i class="icon-material-outline-settings"></i>
                                Settings
                            </a>
                        </li>
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
