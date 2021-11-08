<div class="contest-row-card">
    <div class="d-flex flex-md-row flex-column">
        <div class="context-image-container">
            <a href="{{ route('offers.project-managers.show', ['offer_slug' => $offer->slug]) }}">
                {{-- <img src="{{ asset(is_null($offer->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$offer->user->avatar}") }}"
                    alt=""> --}}
                <img src="{{ asset($file_location.$offer->sub_category->picture) }}" alt="">
            </a>
        </div>
        <div class="contest-info-container">
            <a href="{{ route('offers.project-managers.show', ['offer_slug' => $offer->slug]) }}">
                <div class="contest-row-card-title">
                    {{ $offer->title }}
                </div>
            </a>
            <div class="contest-row-card-description">
                {{ substr($offer->description, 0, 100) }}
            </div>
            <div class="context-row-card-tags d-flex flex-wrap">
                <div class="context-row-card-tag-each border-dark">
                    <i class="icon-line-awesome-star"></i>
                    @if ($offer->minimum_designer_level == 0)
                        Any designer can apply
                    @else
                        Only designers with minimum of {{ $offer->minimum_designer_level }} can apply
                    @endif
                </div>
                {{-- @foreach ($offer->addons->take(2) as $offer_addon)
                    <div class="context-row-card-tag-each border-info text-info">
                        {{ $offer_addon->addon->title }}
                    </div>
                @endforeach --}}
            </div>
            @if (!$offer->payment)
                <a href="{{ route('offers.project-managers.payment', ['offer' => $offer->id]) }}"
                    class="btn btn-sm btn-info">
                    Make Payment Now
                </a>
            @endif
            @if($offer->status !== 'on hold' && auth()->check() && (auth()->user()->is_admin || auth()->user()->super_admin))
                <a href="#dispute-popup-{{ $offer->id }}" class="btn btn-sm btn-primary ripple-effect ico popup-with-zoom-anim" title="Hold offer" data-tippy-placement="top">
                    Hold Offer
                </a>
            @endif
            @if($offer->status == 'on hold' && auth()->check() && (auth()->user()->is_admin || auth()->user()->super_admin))
                <a href="{{ route('admin.offers.project-manager.resolve', $offer->id) }}" class="btn btn-sm btn-secondary">
                    Resolve Contest
                </a>
            @endif
        </div>
        <div class="contest-row-card-right d-flex flex-column justify-content-center">
            <div class="contest-row-card-right-each">
                <i class="icon-material-outline-local-atm"></i>
                <span>
                    {{-- {{ $user_currency == 'dollar' ? "$" : '₦' }}{{ number_format(intval(getCurrencyAmount($offer->currency, $offer->budget, $offer->currency))) }} --}}
                    {{ $user_currency == 'dollar' ? "$" : '₦' }}{{ number_format(intval(getUserCurrencyAmount($user_currency, $offer->budget, $offer->currency, $dollar_rate))) }}
                    {{-- {{ $user_location_currency->symbol }}{{ number_format(intval(getCurrencyAmount($offer->currency, $offer->budget, $offer->currency))) }} --}}
                    {{-- ${{ number_format($offer->budget) }} --}}
                </span>
            </div>
            <div class="contest-row-card-right-each">
                <i class="icon-line-awesome-align-left"></i>
                <span>
                    {{ $offer->delivery_mode == 'continuous' ? 'Continuous' : 'One time' }}
                </span>
            </div>
            <div class="contest-row-card-right-each">
                <i class="icon-line-awesome-users"></i>
                <span>
                    {{ $offer->timeline }} day{{ $offer->timeline > 1 ? 's' : '' }}
                </span>
            </div>
        </div>
        @if($offer->status == 'pending')
            <div class="status-strip bg-secondary text-white d-none d-sm-block">
                {{ $offer->status }}
            </div>
        @elseif($offer->status == 'active')
            <div class="status-strip bg-success text-white d-none d-sm-block">
                {{ $offer->status }}
            </div>
        @elseif($offer->status == 'inactive')
            <div class="status-strip bg-danger text-white d-none d-sm-block">
                {{ $offer->status }}
            </div>
        @elseif($offer->status == 'ongoing')
            <div class="status-strip text-white d-none d-sm-block" style="background-color: blue">
                {{ $offer->status }}
            </div>
        @elseif($offer->status == 'on hold')
            <div class="status-strip text-white d-none d-sm-block" style="background-color: red">
                {{ $offer->status }}
            </div>
        @else
            <div class="status-strip text-white d-none d-sm-block" style="background-color: #001808">
                {{ $offer->status }}
            </div>
        @endif
    </div>
</div>
<div id="dispute-popup-{{ $offer->id }}" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a>Report {{ $offer->title }} Offer</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Form -->
                <form method="post" action="{{ route('admin.offers.project-manager.dispute') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="offer" value="{{ $offer->id }}">

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