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

                    <ul data-submenu-title="Start">
                        <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="icon-material-outline-dashboard"></i> Dashboard
                            </a>
                        </li>
                    </ul>

                    <ul data-submenu-title="Manage Settings">
                        <li class="{{ in_array(Route::currentRouteName(), ['admin.contests.categories.index']) ? 'active-submenu' : '' }}">
                            <a href="#"><i class="icon-material-outline-assignment"></i> Contest Settings</a>
                            <ul>
                                <li class="{{ Route::currentRouteName() == 'admin.contests.categories.index' ? 'active' : '' }}">
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
                    </ul>

                </div>
            </div>
            <!-- Navigation / End -->

        </div>
    </div>
</div>
