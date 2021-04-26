<div class="contest-row-card">
    <div class="d-flex flex-md-row flex-column">
        <div class="context-image-container">
            <a href="{{ route('offers.project-managers.show', ['offer_slug' => $offer->slug]) }}">
                <img src="{{ asset(is_null($offer->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$offer->user->avatar}") }}"
                    alt="">
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
                <div>
                    <a href="{{ route('offers.project-managers.payment', ['offer' => $offer->id]) }}"
                        class="btn btn-sm btn-info">
                        Make Payment Now
                    </a>
                </div>
            @endif
        </div>
        <div class="contest-row-card-right d-flex flex-column justify-content-center">
            <div class="contest-row-card-right-each">
                <i class="icon-material-outline-local-atm"></i>
                <span>
                    {{ $offer->currency == 'dollar' ? "$" : '₦' }}{{ number_format(intval(getCurrencyAmount($offer->currency, $offer->budget, $offer->currency))) }}
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
    </div>
</div>
