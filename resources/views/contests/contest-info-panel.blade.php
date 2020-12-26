<div class="sidebar-widget mt-4">
    <div class="job-overview">
        <div class="job-overview-headline d-none">
            Contest Information
        </div>
        <div class="job-overview-inner">
            <ul>
                <li>
                    <i class="icon-line-awesome-trophy"></i>
                    <span>
                        {{ $contest->possible_winners_count }}
                    </span>
                    <h5>
                        Possible Winner{{ $contest->possible_winners_count > 1 ? 's' : '' }}
                    </h5>
                </li>
                @if($contest->payment()->exists())
                    <li>
                        <i class="icon-line-awesome-clock-o"></i>
                        <span>
                            {{ $contest->payment->created_at->diffForHumans() }}
                        </span>
                        <h5>
                            Date Posted
                        </h5>
                    </li>
                @endif
                <li>
                    <i class="icon-material-outline-local-atm"></i>
                    <span>
                        ${{ number_format($contest->first_place_prize) }}
                    </span>
                    <h5>1st Place</h5>
                </li>
                @if (!is_null($contest->second_place_prize))
                    <li>
                        <i class="icon-material-outline-local-atm"></i>
                        <span>
                            ${{ number_format($contest->second_place_prize) }}
                        </span>
                        <h5>2nd Place</h5>
                    </li>
                @endif
                @if (!is_null($contest->third_place_prize))
                    <li>
                        <i class="icon-material-outline-local-atm"></i>
                        <span>
                            ${{ number_format($contest->third_place_prize) }}
                        </span>
                        <h5>3rd Place</h5>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
