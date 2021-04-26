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
                        {{ $offer->currency == 'dollar' ? "$" : '₦' }}{{ number_format(intval(getCurrencyAmount($offer->currency, $interest->price, $offer->currency))) }}
                    </strong>
                    {{-- <strong>${{ number_format($interest->price) }}</strong> --}}
                </li>
            </ul>
        </div>
        <div class="d-flex">
            <a href="{{ route('account.profile', ['username' => $interest->user->username]) }}" target="_blank"
                class="button button-sliding-icon btn-custom-primary ripple-effect mx-1 text-white" style="flex: 1">
                View Profile
                <i class="icon-material-outline-arrow-right-alt"></i>
            </a>

            @if ($offer->interests->where('assigned', true)->count() < 1)
                <button class="button button-sliding-icon btn-light ripple-effect mx-1 flex-1 assign-freelancer"
                    style="flex: 1;background-color: white;color: black;" data-interest="{{ $interest->id }}">
                    Assign Offer
                    <i class=" icon-feather-check"></i>
                </button>
            @endif
        </div>
    </div>
</div>
