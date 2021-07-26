<div class="contest-row-card {{ $contest->addons->where('addon_id', 1)->count() ? 'top-rated' : '' }}">
    <div class="d-flex flex-md-row flex-column">
        <div class="context-image-container">
            <a href="{{ route('contests.show', ['slug' => $contest->slug]) }}">
                <img src="{{ asset(is_null($contest->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$contest->user->avatar}") }}"
                    alt="">
            </a>
        </div>
        <div class="contest-info-container">
            <a href="{{ route('contests.show', ['slug' => $contest->slug]) }}">
                <div class="contest-row-card-title">
                    {{ $contest->title }}
                </div>
            </a>
            <div class="contest-row-card-description">
                {{ substr($contest->description, 0, 100) }}
            </div>
            <div class="context-row-card-tags d-flex flex-wrap">
                <div class="context-row-card-tag-each border-dark">
                    <i class="icon-line-awesome-star"></i>
                    @if ($contest->minimum_designer_level == 0)
                        Any designer can apply
                    @else
                        Only designers with minimum of {{ $contest->minimum_designer_level }} can apply
                    @endif
                </div>
                @if ($contest->payment()->exists())
                    <div class="context-row-card-tag-each border-success text-success text-uppercase">
                        Guaranteed
                    </div>
                @endif
                @foreach ($contest->addons->take(2) as $contest_addon)
                    <div class="context-row-card-tag-each border-info text-info">
                        {{ $contest_addon->addon->title }}
                    </div>
                @endforeach
            </div>
            @if (!$contest->payment && auth()->check() && auth()->user()->id == $contest->user_id)
                <div>
                    <a href="{{ route('contests.payment', ['contest' => $contest]) }}" class="btn btn-sm btn-info">
                        Make Payment Now
                    </a>
                </div>
            @endif
        </div>
        <div class="contest-row-card-right">
            <div class="contest-row-card-right-each">
                <i class="icon-material-outline-local-atm"></i>
                <span>
                    {{ $user_location_currency->symbol }}{{ number_format(intval(getCurrencyAmount($contest->currency, array_sum($contest->prize_money), $user_location_currency->name))) }}
                    {{-- {{ $user_location_currency->symbol }}{{ number_format(intval(getCurrencyAmount($contest->currency, $contest->prize_money[1], $user_location_currency->name))) }} --}}
                    {{-- {{ number_format($contest->first_place_prize) }} --}}
                </span>
            </div>
            <div class="contest-row-card-right-each">
                <i class="icon-line-awesome-clock-o"></i>
                <span>
                    {{ $contest->ends_at ? $contest->ends_at->diffForHumans() : '-' }}
                </span>
            </div>
            <div class="contest-row-card-right-each">
                <i class="icon-line-awesome-align-left"></i>
                <span>
                    {{ $contest->submissions->count() }} Submissions
                </span>
            </div>
            <div class="contest-row-card-right-each">
                <i class="icon-line-awesome-users"></i>
                <span>
                    {{ $contest->designers_count }} Designers
                </span>
            </div>
        </div>

        <div class="status-strip bg-success text-white d-none d-sm-block">
            Completed
        </div>
    </div>
</div>
{{-- <a href="{{ route("contests.show", ["slug" => $contest->slug]) }}">
</a> --}}

<a href="{{ route('contests.show', ['slug' => $contest->slug]) }}" class="job-listing with-apply-button d-none">
    <div class="job-listing-details">
        <div class="job-listing-company-logo listing-user-avatar">
            <img src="{{ asset(is_null($contest->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$contest->user->avatar}") }}"
                alt="">
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
                        @if ($contest->minimum_designer_level == 0)
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
