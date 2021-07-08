<div
    class="contest-row-card {{ $contest->addons->where('addon_id', 1)->count() ? 'top-rated' : '' }} contest-box-card">
    <div class="d-flex flex-column">
        <a href="{{ route('contests.show', ['slug' => $contest->slug]) }}">
            <div class="context-image-container">
                <img src="{{ asset(is_null($contest->user->avatar) ? 'images/user-avatar-placeholder.png' : "storage/avatars/{$contest->user->avatar}") }}"
                    alt="">
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
