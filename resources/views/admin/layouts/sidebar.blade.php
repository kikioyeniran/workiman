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

                    <ul data-submenu-title="Start">
                        <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="icon-material-outline-dashboard"></i> Dashboard
                            </a>
                        </li>
                    </ul>
                    @if(auth()->user()->super_admin == true)
                        <ul data-submenu-title="Users">
                            <li
                                class="{{ in_array(Route::currentRouteName(), ['admin.contests.categories.index']) ? 'active-submenu' : '' }}">
                                <a href="#"><i class="icon-material-outline-assignment"></i> User Settings</a>
                                <ul>
                                    <li
                                        class="{{ Route::currentRouteName() == 'admin.users.index' ? 'active' : '' }}">
                                        <a href="{{ route('admin.users.index', ['user_category' => 'project-managers']) }}">
                                            All Users
                                        </a>
                                    </li>
                                    <li
                                        class="">
                                        <a href="{{ route('admin.admin-users.index') }}">
                                            Admin Users
                                        </a>
                                    </li>
                                    <li
                                        class="">
                                        <a href="{{ route('admin.users.index', ['user_category' => 'freelancers']) }}">
                                            Freelancers
                                        </a>
                                    </li>
                                    <li
                                        class="">
                                        <a href="{{ route('admin.users.index', ['user_category' => 'project-managers']) }}">
                                            Project Manager
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <ul data-submenu-title="General Settings">
                            <li
                                class="{{ in_array(Route::currentRouteName(), ['admin.sliders.index']) ? 'active-submenu' : '' }}">
                                <a href="#"><i class="icon-material-outline-assignment"></i> Slider Settings</a>
                                <ul>
                                    <li
                                        class="{{ in_array(Route::currentRouteName(), ['admin.sliders.index']) ? 'active-submenu' : '' }}">
                                        <a href="{{ route('admin.sliders.index') }}">
                                            <i class="icon-material-outline-assignment"></i> Slider
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endif



                    <ul data-submenu-title="Manage Settings">
                        <li
                            class="{{ in_array(Route::currentRouteName(), ['admin.contests.categories.index']) ? 'active-submenu' : '' }}">
                            <a href="#"><i class="icon-material-outline-assignment"></i> Contest Settings</a>
                            <ul>
                                <li
                                    class="{{ Route::currentRouteName() == 'admin.contests.index' ? 'active' : '' }}">
                                    <a href="{{ route('admin.contests.index') }}">
                                        All Contests
                                    </a>
                                </li>
                                <li
                                    class="{{ Route::currentRouteName() == 'admin.contests.categories.index' ? 'active' : '' }}">
                                    <a href="{{ route('admin.contests.categories.index') }}">
                                        Categories
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="{{ Route::currentRouteName() == 'admin.contests.addons.index' ? 'active' : '' }}">
                            <a href="{{ route('admin.contests.addons.index') }}">
                                <i class="icon-material-baseline-star-border"></i> Contest Addons
                            </a>
                        </li>

                        <li
                            class="{{ in_array(Route::currentRouteName(), ['admin.offers.categories.index']) ? 'active-submenu' : '' }}">
                            <a href="#"><i class="icon-material-outline-assignment"></i> Offer Settings</a>
                            <ul>
                                <li
                                    class="{{ Route::currentRouteName() == 'admin.offers.categories.index' ? 'active' : '' }}">
                                    <a href="{{ route('admin.offers.categories.index') }}">
                                        Categories
                                    </a>
                                </li>
                                <li
                                    class="{{ Route::currentRouteName() == 'admin.offers.categories.index' ? 'active' : '' }}">
                                    <a href="{{ route('admin.offers.project-manager') }}">
                                        Project Manager Offers
                                    </a>
                                </li>
                                <li
                                    class="{{ Route::currentRouteName() == 'admin.offers.categories.index' ? 'active' : '' }}">
                                    <a href="{{ route('admin.offers.freelancer') }}">
                                        Freelancer Offers
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <ul data-submenu-title="Withdrawals">
                        <li
                            class="{{ Route::currentRouteName() == 'admin.withdrawals' && isset($status) && $status == 'pending' ? 'active' : '' }}">
                            <a href="{{ route('admin.withdrawals', ['status' => 'pending']) }}">
                                <i class=" icon-line-awesome-money"></i> Pending
                            </a>
                        </li>
                        <li
                            class="{{ Route::currentRouteName() == 'admin.withdrawals' && isset($status) && $status == 'approved' ? 'active' : '' }}">
                            <a href="{{ route('admin.withdrawals', ['status' => 'approved']) }}">
                                <i class=" icon-line-awesome-money"></i> Completed
                            </a>
                        </li>
                        <li
                            class="{{ Route::currentRouteName() == 'admin.withdrawals' && isset($status) && $status == 'rejected' ? 'active' : '' }}">
                            <a href="{{ route('admin.withdrawals', ['status' => 'rejected']) }}">
                                <i class=" icon-line-awesome-money"></i> Rejected
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
            <!-- Navigation / End -->

        </div>
    </div>
</div>
