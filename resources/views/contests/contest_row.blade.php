<a href="{{ route("contests.show", ["slug" => $contest->slug]) }}" class="job-listing with-apply-button">
    <div class="job-listing-details">
        <div class="job-listing-company-logo listing-user-avatar">
            <img src="{{ asset(is_null($contest->user->avatar) ? ("images/user-avatar-placeholder.png") : ("storage/avatars/{$contest->user->avatar}")) }}" alt="">
        </div>
        <div class="job-listing-description">
            <h3 class="job-listing-title">
                {{ $contest->title }}
            </h3>
            <div class="job-listing-footer">
                <ul class="text-small">
                    <li class="d-none">
                        <i class="icon-material-outline-business"></i>
                        Hexagon
                        <div class="verified-badge" title="Verified Employer" data-tippy-placement="top"></div>
                    </li>
                    <li>
                        <i class="icon-material-outline-bookmark-border"></i>
                        {{ $contest->sub_category->title }}
                    </li>
                    <li>
                        <i class="icon-material-outline-business-center"></i>
                        @if($contest->minimum_designer_level == 0)
                            Any designer can apply
                        @else
                            Only designers with minimum of {{ $contest->minimum_designer_level }} can apply
                        @endif
                    </li>
                    <li>
                        <i class="icon-material-outline-access-time"></i>
                        {{ $contest->created_at->diffForHumans() }}
                    </li>
                </ul>
            </div>
        </div>
        {{-- <span class="bookmark-icon"></span> --}}
        <span class="list-apply-button ripple-effect">
            View
        </span>
    </div>
</a>
