<div class="freelancer">
    <!-- Overview -->
    <div class="freelancer-overview pb-3">
        <div class="freelancer-overview-inner">

            <!-- Bookmark Icon -->
            {{-- <span class="bookmark-icon"></span> --}}

            <!-- Avatar -->
            <div class="freelancer-avatar">
                {{-- <div class="verified-badge"></div> --}}
                <a href="#">
                    <img src="{{ asset(is_null($interest->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$interest->user->avatar}") }}"
                        alt="">
                </a>
            </div>

            <!-- Name -->
            <div class="freelancer-name">
                <h4>
                    <a href="{{ route('account.profile', ['username' => $interest->user->username]) }}"
                        target="_blank">
                        {{ $interest->user->display_name }}
                    </a>
                </h4>
                {{-- <span>UI/UX Designer</span> --}}
            </div>

            <!-- Rating -->
            <div class="freelancer-rating">
                <div class="star-rating" data-rating="4.9"></div>
            </div>

            <div class="d-flex align-items-center justify-content-center">
                <a class="btn btn-light btn-sm mt-2 popup-with-zoom-anim"
                    href="#interest{{ $interest->id }}ProposalModal">
                    View Proposal
                    <i class=" icon-line-awesome-ellipsis-h"></i>
                </a>
                @if ($interest->assigned)
                    <span class="badge badge-success mt-2 ml-3">
                        Assigned
                        <i class=" icon-feather-check-circle"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Details -->
    <div class="freelancer-details p-2">
        <div class="freelancer-details-list">
            <ul class="text-center">
                <li>
                    <i class="icon-feather-calendar"></i>
                    <strong>{{ $interest->timeline }} Day{{ $interest->timeline > 1 ? 's' : '' }}</strong>
                </li>
                <li>
                    <i class=" icon-line-awesome-money"></i>
                    <strong>
                        {{-- {{ $offer->currency == 'dollar' ? "$" : '₦' }}{{ number_format(intval(getCurrencyAmount($offer->currency, $interest->price, $offer->currency))) }} --}}
                        {{ $user_currency == 'dollar' ? "$" : '₦' }}{{ number_format(intval(getUserCurrencyAmount($user_currency, $interest->price, $offer->currency, $dollar_rate))) }}
                    </strong>
                    {{-- <strong>${{ number_format($interest->price) }}</strong> --}}
                </li>
            </ul>
        </div>
        @if($interest->status == 'pending')
            <div class="d-flex">
                <a href="{{ route('offers.accept-interest', ['interest' => $interest->id]) }}" target="_blank"
                    class="btn button-sliding-icon btn-primary ripple-effect mx-1 text-white" style="flex: 1">
                    Accept Interest
                    <i class="icon-material-outline-arrow-right-alt"></i>
                </a>
                <a href="{{ route('offers.decline-interest', ['interest' => $interest->id]) }}" target="_blank"
                    class="btn button-sliding-icon btn-danger ripple-effect mx-1 text-white" style="flex: 1">
                    Decline Interest
                    <i class="icon-material-outline-arrow-right-alt"></i>
                </a>
            </div>
        @elseif($interest->status == 'declined')
            <div class="d-flex">
                <a href="#" target="_blank"
                    class="btn button-sliding-icon btn-danger ripple-effect mx-1 text-white" style="flex: 1">
                    Interest Declined
                    <i class="icon-material-outline-arrow-right-alt"></i>
                </a>
            </div>
        @elseif($interest->status == 'accepted' && !$interest->is_paid)
            <div class="d-flex">
                <a href="#" target="_blank"
                    class="btn button-sliding-icon btn-secondary ripple-effect mx-1 text-white" style="flex: 1">
                    Awaiting Payment
                    <i class="icon-material-outline-arrow-right-alt"></i>
                </a>
            </div>
        @else
            <div class="d-flex">
                <a href="{{ route('account.profile', ['username' => $interest->user->username]) }}" target="_blank"
                    class="button button-sliding-icon btn-custom-primary ripple-effect mx-1 text-white" style="flex: 1">
                    View Profile
                    <i class="icon-material-outline-arrow-right-alt"></i>
                </a>
                <a href="{{ route('offers.paid-interests.show', ['offer' => $interest->freelancer_offer_id, 'interest' => $interest->id]) }}" target="_blank"
                    class="button button-sliding-icon btn-custom-primary ripple-effect mx-1 text-white" style="flex: 1">
                    Submissions
                    <i class="icon-material-outline-arrow-right-alt"></i>
                </a>
            </div>
        @endif
    </div>
</div>
