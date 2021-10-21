<div class="contest-row-card {{ $contest->addons->where('addon_id', 1)->count() ? 'top-rated' : '' }}">
    <div class="d-flex flex-md-row flex-column">
        <div class="context-image-container">
            <a href="{{ route('contests.show', ['slug' => $contest->slug]) }}">
                {{-- <img src="{{ asset(is_null($contest->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$contest->user->avatar}") }}"
                    alt=""> --}}
                <img src="{{ asset($file_location.$contest->sub_category->picture) }}"
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
            @if($contest->status == 'inactive' && auth()->check() && auth()->user()->id == $contest->user_id || $contest->status == 'inactive' && auth()->check() && auth()->user()->super_admin)
                {{-- <div> --}}
                    <a href="{{ route('contests.extend-contest', ['contest_id' => $contest->id]) }}" class="btn btn-sm btn-info">
                        Extend Contest Time
                    </a>
                {{-- </div> --}}
            @endif
            @if($contest->status == 'on hold' && auth()->check() && (auth()->user()->is_admin || auth()->user()->super_admin))
                <div>
                    <a href="{{ route('admin.contests.resolve', $contest->id) }}" class="btn btn-sm btn-secondary">
                        Resolve Contest
                    </a>
                </div>
            @endif
            @if($contest->status !== 'on hold' && auth()->check() && (auth()->user()->is_admin || auth()->user()->super_admin))
                {{-- <div> --}}
                    <a href="#dispute-popup-{{ $contest->id }}" class="btn btn-sm btn-primary ripple-effect ico popup-with-zoom-anim" title="Hold Contest" data-tippy-placement="top">
                        Report/Hold Contest
                    </a>
                {{-- </div> --}}
            @endif
            @if($contest->status == 'active' && auth()->check() && (!auth()->user()->is_admin && !auth()->user()->super_admin))
                {{-- <div> --}}
                    <a href="#user-dispute-popup-{{ $contest->id }}" class="btn btn-sm btn-primary ripple-effect ico popup-with-zoom-anim" title="Hold Contest" data-tippy-placement="top">
                        Report This Contest
                    </a>
                {{-- </div> --}}
            @endif
        </div>
        <div class="contest-row-card-right">
            <div class="contest-row-card-right-each">
                <i class="icon-material-outline-local-atm"></i>
                <span>
                    {{-- {{ $user_location_currency->symbol }}{{ number_format(intval(getCurrencyAmount($contest->currency, array_sum($contest->prize_money), $user_location_currency->name))) }} --}}
                    {{ $user_currency == 'dollar' ? "$" : '₦' }}{{ number_format(intval(getUserCurrencyAmount($user_currency, array_sum($contest->prize_money), $contest->currency, $dollar_rate))) }}
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

        @if($contest->status == 'pending')
            <div class="status-strip bg-secondary text-white d-none d-sm-block">
                {{ $contest->status }}
            </div>
        @elseif($contest->status == 'active')
            <div class="status-strip bg-success text-white d-none d-sm-block">
                {{ $contest->status }}
            </div>
        @elseif($contest->status == 'inactive' || $contest->status == 'on hold')
            <div class="status-strip bg-danger text-white d-none d-sm-block">
                {{ $contest->status }}
            </div>
        @else
            <div class="status-strip bg-warning text-white d-none d-sm-block">
                {{ $contest->status }}
            </div>
        @endif

        {{-- <div class="status-strip bg-success text-white d-none d-sm-block">
            {{ $contest->status }}
        </div> --}}
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

<div id="dispute-popup-{{ $contest->id }}" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a>Report {{ $contest->title }} Contest</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Form -->
                <form method="post" action="{{ route('admin.contests.dispute') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="contest" value="{{ $contest->id }}">

                    {{-- <input class=" with-border default margin-bottom-20" name="title" placeholder="Category Title" value="{{ $sub_category->title }}" required />

                    <input type="number" class=" with-border default margin-bottom-20" name="base_amount" placeholder="Base Amount" value="{{ $sub_category->base_amount }}" required /> --}}

                    <Textarea class=" with-border default margin-bottom-20" name='comments' placeholder="Add Comments Here"></Textarea>
                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save <i class="icon-material-outline-arrow-right-alt"></i></button>

                </form>
            </div>

        </div>
    </div>
</div>

<div id="user-dispute-popup-{{ $contest->id }}" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a>Report {{ $contest->title }} Contest</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Form -->
                <form method="post" action="{{ route('account.contests.dispute') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="contest" value="{{ $contest->id }}">

                    {{-- <input class=" with-border default margin-bottom-20" name="title" placeholder="Category Title" value="{{ $sub_category->title }}" required />

                    <input type="number" class=" with-border default margin-bottom-20" name="base_amount" placeholder="Base Amount" value="{{ $sub_category->base_amount }}" required /> --}}

                    <Textarea class=" with-border default margin-bottom-20" name='comments' placeholder="Add Comments Here"></Textarea>
                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save <i class="icon-material-outline-arrow-right-alt"></i></button>

                </form>
            </div>

        </div>
    </div>
</div>
