<div class="contest-row-card">
    <div class="d-flex flex-md-row flex-column">
        <div class="context-image-container">
            <a href="{{ route('offers.freelancers.show', ['offer_slug' => $offer->slug]) }}">
                {{-- <img src="{{ asset(is_null($offer->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$offer->user->avatar}") }}"
                    alt=""> --}}
                <img src="{{ asset($file_location.$offer->sub_category->picture) }}"
                    alt="">
            </a>
        </div>
        <div class="contest-info-container">
            <a href="{{ route('offers.freelancers.show', ['offer_slug' => $offer->slug]) }}">
                <div class="contest-row-card-title">
                    {{ $offer->title }}
                </div>
            </a>
            <div class="contest-row-card-description">
                {{ substr($offer->description, 0, 100) }}...
            </div>
            <div class="context-row-card-tags d-flex flex-wrap">
                <div class="context-row-card-tag-each border-dark">
                    <i class="icon-line-awesome-star"></i>
                    {{ $offer->sub_category->offer_category->title }}
                </div>
            </div>
        </div>
        <div class="contest-row-card-right d-flex flex-column justify-content-center">
            <div class="contest-row-card-right-each">
                <i class="icon-material-outline-local-atm"></i>
                <span>
                    {{-- {{ $offer->currency == 'dollar' ? '$' : '₦' }}{{ number_format($offer->price) }} --}}
                    {{ $user_currency == 'dollar' ? '$' : '₦' }}{{ number_format(intval(getUserCurrencyAmount($user_currency, $offer->price, $offer->currency, $dollar_rate)), 2) }}
                </span>
            </div>
            {{-- <div class="contest-row-card-right-each">
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
            </div> --}}
        </div>

        {{-- @if($contest->status == 'pending')
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
        @endif --}}
    </div>
</div>
