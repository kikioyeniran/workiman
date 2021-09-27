<div class="single-page-header-inner">
    <div class="left-side">
        <div class="header-image">
            <a href="{{ route('contests.user', ['username' => $contest->user->username]) }}">
                {{-- <img src="{{ asset(is_null($contest->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$contest->user->avatar}") }}"
                    alt=""> --}}
                <img src="{{ asset($file_location.$contest->sub_category->picture) }}"
                    alt="">
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
                        @if ($contest->minimum_designer_level == 0)
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
                Winner
            </div>
            <div class="salary-amount">
                {{-- ${{ number_format($contest->first_place_prize) }} --}}
                {{ $user_location_currency->symbol }}{{ number_format(intval(getCurrencyAmount($contest->currency, array_sum($contest->prize_money), $user_location_currency->name))) }}
                {{-- {{ $user_location_currency->symbol }}{{ number_format(intval(getCurrencyAmount($contest->currency, $contest->prize_money[1], $user_location_currency->name))) }} --}}
                {{-- ${{ number_format($contest->first_place_prize + $contest->second_place_prize + $contest->third_place_prize) }} --}}
            </div>
        </div>
    </div>
</div>
