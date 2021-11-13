<div
    class="contest-row-card {{ $contest->addons->where('addon_id', 1)->count() ? 'top-rated' : '' }} contest-box-card">
    <div class="d-flex flex-column">
        <a href="{{ route('contests.show', ['slug' => $contest->slug]) }}">
            <div class="context-image-container">
                {{-- <img src="{{ asset(is_null($contest->sub_category->picture) ? 'images/user-avatar-placeholder.png' : "{$file_location.$contest->sub_category->picture}") }}"
                    alt=""> --}}
                @if($contest->first_position != null)
                    {{-- <div>{{ $contest->first_position->files }}</div> --}}
                    <img src="{{ asset("storage/contest-submission-files/{$contest->first_position->files[0]->content}") }}" alt="">
                @else
                    <img src="{{ $contest->sub_category->picture ? asset($file_location.$contest->sub_category->picture) : "images/user-avatar-placeholder.png" }}" alt="">
                @endif


            </div>
        </a>
        <div class="d-flex">
            <div class="p-3 flex-grow-1">
                <div class="text-center">
                    <h4 class="mb-1">
                        {{ $contest->designers_count }}
                    </h4>
                    <small class="text-muted">
                        Designers
                    </small>
                </div>
            </div>
            <div class="p-3 flex-grow-1">
                <div class="text-center">
                    <h4 class="mb-1">
                        {{ $contest->submissions->count() }}
                    </h4>
                    <small class="text-muted">
                        Submissions
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
