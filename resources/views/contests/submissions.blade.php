@extends('layouts.app')

@section('page_title', "Submission for - {$contest->title}")

@section('page_styles')
    <style>
        .comment-box {
            border-radius: 3px;
            padding: 5px;
            font-size: x-small;
            background-color: #f0f0f0;
        }

    </style>
@endsection

@section('page_content')

    <div class="single-page-header" data-background-image="{{ asset('_home/images/single-job.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include("contests.contest_header", ["contest" => $contest])
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <!-- Content -->
            <div class="col-xl-8 col-lg-8 content-right-offset">

                <div class="single-page-section">
                    <h3 class="margin-bottom-25">
                        @yield("page_title")
                    </h3>
                    @forelse ($contest->submissions as $submission)
                        <div class="contest-submission-card">
                            <div class="row">
                                <div class="contest-submission-card-left col-md-8 col-lg-9">
                                    <div class="d-flex">
                                        <small class="mr-3 text-secondary">
                                            #{{ $submission->reference }}
                                        </small>
                                        <h6>
                                            <i class="icon-feather-user"></i>
                                            {{ $submission->user->username }}
                                        </h6>
                                    </div>
                                    <div class="contest-submission-card-thumbnails">
                                        @foreach ($submission->files as $submission_file)
                                            <img src="{{ asset("storage/contest-submission-files/{$submission_file->content}") }}"
                                                data-id="{{ $submission->id }}"
                                                data-file="{{ $submission_file->id }}"
                                                data-username="{{ $submission->user->username }}" alt=""
                                                class="img-fluid img-thumbnail submission-thumbnail"
                                                data-comments="{{ $submission_file->comments }}">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="contest-submission-card-left col-md-4 col-lg-3 flex-column justify-content-around text-right">
                                    <a class="btn btn-custom-outline-primary my-1 d-none"
                                        href="{{ route('contests.submission.download-files', ['slug' => $contest->slug, 'submission' => $submission->id]) }}">
                                        <small>
                                            Download Files
                                            <i class="icon-feather-download"></i>
                                        </small>
                                    </a>
                                    <a class="btn btn-custom-outline-primary my-1" href="{{ route('contests.submission', ['slug' => $contest->slug, 'submission' => $submission->id]) }}">
                                        <small>
                                            View
                                            <i class="fa icon-feather-info"></i>
                                        </small>
                                    </a>
                                    {{-- @if (!is_null($submission->description))
                                    @endif --}}
                                </div>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-dark mr-2" disabled style="cursor: default">
                                    <i class="icon-line-awesome-trophy"></i>
                                </button>
                                <button
                                    class="btn btn-{{ $submission->position != 1 ? 'outline-' : '' }}success px-4 py-1 mr-2 choose-winner-btn"
                                    data-position="1" data-contestant="{{ $submission->user_id }}"
                                    data-submission="{{ $submission->id }}">
                                    <small>
                                        1st
                                    </small>
                                </button>
                                @if (!is_null($contest->second_place_prize))
                                    <button
                                        class="btn btn-{{ $submission->position != 2 ? 'outline-' : '' }}info px-4 py-1 mr-2 choose-winner-btn"
                                        data-position="2" data-contestant="{{ $submission->user_id }}"
                                        data-submission="{{ $submission->id }}">
                                        <small>
                                            2nd
                                        </small>
                                    </button>
                                @endif
                                @if (!is_null($contest->third_place_prize))
                                    <button
                                        class="btn btn-{{ $submission->position != 2 ? 'outline-' : '' }}warning px-4 py-1 mr-2 choose-winner-btn"
                                        data-position="3" data-contestant="{{ $submission->user_id }}"
                                        data-submission="{{ $submission->id }}">
                                        <small>
                                            3rd
                                        </small>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info text-center">
                            <small>
                                This contest has no submissions at the moment.
                            </small>
                        </div>
                    @endforelse
                </div>

            </div>


            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">

                    @if (is_null($contest->ends_at))
                        <div class="text-center mb-3">
                            <h3 class="text-danger">Inactive</h3>
                        </div>
                    @elseif($contest->ends_at <= \Carbon\Carbon::now()) <div class="text-center mb-0">
                            <small>
                                Ended
                            </small>
                            <br>
                            <h3 class="text-danger mb-0">
                                {{ $contest->ends_at->diffForHumans() }}
                            </h3>
                            <small>
                                ({{ $contest->ends_at->isoFormat('LLLL') }})
                            </small>
                </div>
            @else
                <div class="text-center mb-0">
                    <small>
                        Ends in
                    </small>
                    <br>
                    <h3 class="text-success mb-0">
                        {{ $contest->ends_at->diffForHumans() }}
                    </h3>
                    <small>
                        ({{ $contest->ends_at->isoFormat('LLLL') }})
                    </small>
                </div>
                @endif

                {{-- @if (!is_null($contest->ends_at) && $contest->submissions->where('position', '!=', null)->count() == 0) --}}
                @if (!is_null($contest->ends_at))
                    <a class="apply-now-button bg-white text-dark mt-2 save-selected-winners-btn" data-toggle="modal" href="javascript: void(0)"
                        data-target="#contestantsModal">
                        <small>
                            Save Winner(s) & End Contest
                            <i class="icon-feather-check"></i>
                        </small>
                    </a>
                @endif

                <a href="{{ route('contests.show', ['slug' => $contest->slug]) }}" class="apply-now-button my-3">
                    <i class="icon-feather-arrow-left"></i>
                    Back to contest
                </a>

                @include("contests.contest-info-panel", ["contest" => $contest])

                <!-- Sidebar Widget -->
                <div class="sidebar-widget d-none">
                    <!-- Share Buttons -->
                    <div class="share-buttons margin-top-25">
                        <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                        <div class="share-buttons-content">
                            <span>Interesting? <strong>Share It!</strong></span>
                            <ul class="share-buttons-icons">
                                <li><a href="#" data-button-color="#3b5998" title="Share on Facebook"
                                        data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
                                <li><a href="#" data-button-color="#1da1f2" title="Share on Twitter"
                                        data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                <li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus"
                                        data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
                                <li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn"
                                        data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>

    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

        <!--Tabs -->
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a href="#tab">Attach Submissions</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Welcome Text -->
                    <div class="welcome-text d-none">
                        <h3>Attach Submissions</h3>
                    </div>

                    <form action="{{ route('contests.submit', ['slug' => $contest->slug]) }}" method="POST"
                        id="contest-submissions-form" class="dropzone mb-5" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="contest_id" id="contest_id" value="" required />
                    </form>

                    <!-- Button -->
                    <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                        form="apply-now-form" id="contest-submissions-button">
                        Submit Now <i class="icon-material-outline-arrow-right-alt"></i>
                    </button>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="submissionPreviewModal" tabindex="-1" aria-labelledby="submissionPreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-7 text-center">
                            <img src="#" alt="" style="object-fit: contain;max-height: 70vh">
                        </div>
                        <div class="col-sm-5">
                            <div class="submission-comments-container">
                                <h6>
                                    Comments
                                </h6>
                                <div class="submission-comments">
                                    {{-- @foreach (\App\ContestSubmissionFileComment::get() as $comment)
                                        <div class="d-flex justify-content-end">
                                            <div class="comment-box mb-1">
                                                {{ $comment->content }}
                                                <div>
                                                    <small>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach --}}
                                </div>
                                <form action="">
                                    @csrf
                                    <div class="form-group">
                                        <textarea id="" rows="2" class="form-control" placeholder="Add comments"
                                            required></textarea>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-sm btn-success" type="submit">
                                            Post
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="submissionDescriptionPreviewModal" tabindex="-1"
        aria-labelledby="submissionDescriptionPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
<script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('js/contest-dropzone.js') }}"></script>
<script>
    const submission_comments_container = $(".submission-comments-container")
    const submission_comment_input = submission_comments_container.find('textarea')
    const submission_comment_form = submission_comments_container.find('form')
    let selected_submission_file

    submission_comment_form.on('submit', function(e) {
        e.preventDefault()

        loading_container.show()
        fetch(`${webRoot}contests/{{ $contest->slug }}/submission/${selected_submission_file}/comment`, {
                method: 'post',
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                },
                body: JSON.stringify({
                    _token,
                    comment: submission_comment_input.val()
                })
            }).then(response => response.json())
            .then(async responseJson => {
                if (responseJson.success) {
                    console.log("Success here", responseJson);
                    Snackbar.show({
                        text: responseJson.message,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 10000,
                        textColor: '#fff',
                        backgroundColor: '#28a745'
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000)
                } else {
                    Snackbar.show({
                        text: responseJson.message,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                    $('html, body').animate({
                        scrollTop: $('#wrapper').offset().top
                    }, 500);
                    loading_container.hide();
                }

                // return

            })
            .catch(error => {
                loading_container.hide();
                console.log("Error occurred: ", error);
                Snackbar.show({
                    text: `Error occurred, please try again`,
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                $('html, body').animate({
                    scrollTop: $('#wrapper').offset().top
                }, 500);
            })
    })

</script>
<script>
    let can_select_winners = false

</script>
@if (!is_null($contest->ends_at) && $contest->submissions->where('position', '!=', null)->count() == 0)
    <script>
        can_select_winners = true

    </script>
@endif

<script>
    $(".submission-thumbnail").on('click', function(e) {
        let this_submission = $(e.target)
        selected_submission_file = this_submission.data('file')
        selected_submission_username = this_submission.data('username')

        $("#submissionPreviewModal").find('img').attr({
            src: this_submission.attr('src')
        })
        $("#submissionPreviewModal").modal('show')

        // Show comments
        submission_comments_container.find('.submission-comments').html('')

        let comments = this_submission.data('comments')

        comments.map(comment => {
            $(".submission-comments").append(`
                <div class="d-flex ${comment.user_id == '{{ auth()->user()->id }}' ? 'justify-content-end' : 'justify-content-start'}">
                    <div class="comment-box mb-2">
                        ${comment.content}
                        <div class="${comment.user_id == '{{ auth()->user()->id }}' ? 'text-right' : ''}">
                            <small class="text-muted">
                                ${comment.user_id == '{{ auth()->user()->id }}' ? 'You' : selected_submission_username}
                            </small>
                        </div>
                    </div>
                </div>
            `)
        })
    })

</script>

<script>
    $(".submission-show-description").on('click', function() {
        let this_submission_description_button = $(this)
        let description = this_submission_description_button.data('description')

        $("#submissionDescriptionPreviewModal").find('.modal-body').text(description)
        $("#submissionDescriptionPreviewModal").modal('show')
    })

</script>

<script>
    const choose_winner_btn = $(".choose-winner-btn")
    const save_selected_winners_btn = $(".save-selected-winners-btn")

    console.log(can_select_winners)

    let winners = {
        '1': null,
        '2': null,
        '3': null,
    }

    choose_winner_btn.on("click", function() {
        if (!can_select_winners) {
            return
        }
        let position = $(this).data('position')
        let submission = $(this).data('submission')

        // Remove submission from preveiously selected position
        for (const winner_position in winners) {
            if (Object.hasOwnProperty.call(winners, winner_position)) {
                const element = winners[winner_position];
                if (element == submission) {
                    winners[winner_position] = null
                }
            }
        }

        // Add submission to selected position
        winners[position] = submission

        console.log(winners)

        refreshSelectedWinners()
    })

    function refreshSelectedWinners() {
        $.each($(".choose-winner-btn"), (key, choose_winner_btn_each) => {
            switch ($(choose_winner_btn_each).data('position')) {
                case 1:
                    $(choose_winner_btn_each).removeClass("btn-success")
                    $(choose_winner_btn_each).removeClass("text-white")
                    $(choose_winner_btn_each).addClass("btn-outline-success")

                    if ($(choose_winner_btn_each).data('submission') == winners[1]) {
                        $(choose_winner_btn_each).addClass("btn-success")
                        $(choose_winner_btn_each).addClass("text-white")
                        $(choose_winner_btn_each).removeClass("btn-outline-success")
                    }
                    break;
                case 2:
                    $(choose_winner_btn_each).removeClass("btn-info")
                    $(choose_winner_btn_each).removeClass("text-white")
                    $(choose_winner_btn_each).addClass("btn-outline-info")

                    if ($(choose_winner_btn_each).data('submission') == winners[2]) {
                        $(choose_winner_btn_each).addClass("btn-info")
                        $(choose_winner_btn_each).addClass("text-white")
                        $(choose_winner_btn_each).removeClass("btn-outline-info")
                    }
                    break;
                case 3:
                    $(choose_winner_btn_each).removeClass("btn-warning")
                    $(choose_winner_btn_each).removeClass("text-white")
                    $(choose_winner_btn_each).addClass("btn-outline-warning")

                    if ($(choose_winner_btn_each).data('submission') == winners[3]) {
                        $(choose_winner_btn_each).addClass("btn-warning")
                        $(choose_winner_btn_each).addClass("text-white")
                        $(choose_winner_btn_each).removeClass("btn-outline-warning")
                    }
                    break;
            }
        })
    }

    save_selected_winners_btn.on("click", function() {
        if (!can_select_winners) {
            return
        }
        let possible_winners_count = parseInt(`{{ $contest->possible_winners_count }}`)
        // console.log(winners[1], possible_winners_count)

        switch (possible_winners_count) {
            case 1:
                if (winners[1] == null) {
                    Snackbar.show({
                        text: "Please select a winner.",
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                    return
                }
                break;
            case 2:
                if (winners[1] == null || winners[2] == null) {
                    Snackbar.show({
                        text: "Please select up to 2 winners.",
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                    return
                }
                break;
            case 3:
                if (winners[1] == null || winners[2] == null || winners[3] == null) {
                    Snackbar.show({
                        text: "Please select all 3 winners.",
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                    return
                }
                break;
        }

        let payload = {
            _token,
            winners: winners
        }

        console.log(payload)

        loading_container.show();
        fetch(`{{ route('contests.winners', ['slug' => $contest->slug]) }}`, {
                method: 'post',
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(payload)
            }).then(response => response.json())
            .then(async responseJson => {
                if (responseJson.success) {
                    console.log("Success here", responseJson);
                    Snackbar.show({
                        text: responseJson.message,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 10000,
                        textColor: '#fff',
                        backgroundColor: '#28a745'
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000)
                } else {
                    Snackbar.show({
                        text: responseJson.message,
                        pos: 'top-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 5000,
                        textColor: '#fff',
                        backgroundColor: '#721c24'
                    });
                    $('html, body').animate({
                        scrollTop: $('#wrapper').offset().top
                    }, 500);
                    loading_container.hide();
                }

                // return

            })
            .catch(error => {
                loading_container.hide();
                console.log("Error occurred: ", error);
                Snackbar.show({
                    text: `Error occurred, please try again`,
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                $('html, body').animate({
                    scrollTop: $('#wrapper').offset().top
                }, 500);
            })
    })

</script>
@endsection
