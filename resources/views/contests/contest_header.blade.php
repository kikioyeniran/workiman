<div class="single-page-header-inner">
    <div class="left-side">
        <div class="header-image">
            <a href="single-company-profile.html">
                <img src="{{ asset(is_null($contest->user->avatar) ? ("images/user-avatar-placeholder.png") : ("storage/avatars/{$contest->user->avatar}")) }}" alt="">
            </a>
        </div>
        <div class="header-details">
            <h3>
                {{ $contest->title }}
            </h3>
            <h5>
                {{ $contest->sub_category->contest_category->title }}
            </h5>
            <ul>
                <li>
                    <a>
                        <i class="icon-material-outline-mouse text-custom-primary"></i>
                        @if($contest->minimum_designer_level == 0)
                            Any designer can apply
                        @else
                            Only designers with minimum of {{ $contest->minimum_designer_level }} can apply
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
                ₦{{ number_format($contest->price) }}
            </div>
        </div>
    </div>
</div>
