@extends('layouts.app')

@section('page_title', $contest->title)

@section('page_styles')
    <style>
        .each-contest-attachment {
            background-color: #fff;
            margin-bottom: 10px;
            box-shadow: 3px 3px 15px 10px rgba(0, 0, 0, .05);
            border-radius: 5px;
            padding: 5px 5px 5px 10px;
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


    <!-- Page Content
                                                                                                                                                                                                                                                                                                                                    ================================================== -->
    <div class="container">
        <div class="row d-flex justify-content-center">

            <!-- Content -->
            <div class="col-xl-8 col-lg-8 content-right-offset padding-bottom-100">

                @include("layouts.section-header", ["header" => 'Submission', 'icon' => 'icon-feather-box'])

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
                        </div>
                    </div>
                    <div class="d-flex">
                        @if($submission->position == 1)
                            <button
                                class="btn btn-success px-4 py-1 mr-2 choose-winner-btn"
                                data-position="1" data-contestant="{{ $submission->user_id }}"
                                data-submission="{{ $submission->id }}">
                                <small>
                                    Winner
                                </small>
                            </button>
                        @endif
                        @if($submission->position == 2)
                            <button
                                class="btn btn-info px-4 py-1 mr-2 choose-winner-btn"
                                data-position="2" data-contestant="{{ $submission->user_id }}"
                                data-submission="{{ $submission->id }}">
                                <small>
                                    2nd Position
                                </small>
                            </button>
                        @endif
                        @if($submission->position == 3)
                            <button
                                class="btn btn-warning px-4 py-1 mr-2 choose-winner-btn"
                                data-position="3" data-contestant="{{ $submission->user_id }}"
                                data-submission="{{ $submission->id }}">
                                <small>
                                    3rd Position
                                </small>
                            </button>
                        @endif
                    </div>
                </div>

                @include("layouts.section-header", ["header" => 'Description', 'icon' => 'icon-line-awesome-ellipsis-h'])
                <p>
                    {{ $submission->description }}
                </p>

                @include('layouts.section-header', ['header' => 'Comments', 'icon' => 'icon-line-awesome-comments'])

                <div class="margin-top-20">
                    {{-- @forelse ($offer->comments->where('content_type', 'text') as $comment) --}}
                    @forelse ($submission->comments as $comment)
                        <div class="each-comment-container comment-{{ $comment->user_id == auth()->user()->id ? 'right' : 'left' }}">
                            {{-- <div> --}}
                                @if ($comment->content_type == 'text')
                                    <div class="comment-content">
                                        {{ $comment->content }}
                                    </div>
                                @elseif ($comment->content_type == 'image')
                                    <div class="comment-content files">
                                        @foreach (json_decode($comment->content) as $comment_file)
                                            <div>
                                                <img src="{{ asset("storage/contest-submission-comment-images/{$submission->id}/{$comment_file}") }}" alt="" class="img-thumbnail comment-file">
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($comment->content_type == 'file')
                                    <div class="comment-content files">
                                        <a href="{{ route('contests.submission.comment.download-file', ['slug' => $contest->slug, 'submission' => $submission->id, 'comment' => $comment->id]) }}" class="btn btn-custom-primary">
                                            Download Files
                                            <i class=" icon-feather-download-cloud"></i>
                                        </a>
                                        {{-- @foreach (json_decode($comment->content) as $comment_file)
                                            <div>
                                                <img src="{{ asset("storage/offer-comment-files/{$submission->id}/{$comment_file}") }}" alt="" class="img-thumbnail comment-file">
                                            </div>
                                        @endforeach --}}
                                    </div>
                                @endif
                                <small>
                                    {{ $comment->user->display_name }}
                                </small>
                            {{-- </div> --}}
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <small>
                                Comments unavailable.
                            </small>
                        </div>
                    @endforelse
                </div>

                <hr>

                @if (!$submission->completed)
                    <div class="text-center">
                        <a class="btn btn-custom-primary popup-with-zoom-anim px-4" href="#comment-dialog">
                            Add Comment
                            <i class=" icon-line-awesome-comment"></i>
                        </a>
                        <a class="btn btn-custom-outline-primary popup-with-zoom-anim px-4" href="#upload-image-dialog">
                            Image
                            <i class=" icon-feather-upload"></i>
                        </a>
                        @if (auth()->user()->id == $submission->user->id)
                            <a class="btn btn-custom-primary popup-with-zoom-anim px-4" href="#upload-file-dialog">
                                Upload Raw Files
                                <i class=" icon-line-awesome-cloud-upload"></i>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

    </div>
    </div>

    <div id="comment-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs dialog">
    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab">Add Comment</a></li>
        </ul>

        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <div class="form-group">
                    <textarea name="comment" id="" placeholder="Enter comment here?"></textarea>
                </div>

                <!-- Button -->
                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect"
                    form="apply-now-form" id="add-comment-button">
                    Send <i class="icon-material-outline-arrow-right-alt"></i>
                </button>

            </div>

        </div>
    </div>
</div>

<div id="upload-image-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs dialog">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab">Upload Images</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Welcome Text -->
                <div class="welcome-text d-none">
                    <h3>Upload Images</h3>
                </div>

                <form action="{{ route('contests.submission.comment', ['slug' => $contest->slug, 'submission' => $submission->id]) }}" method="POST"
                    id="upload-image-form" class="dropzone mb-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="contest_id" id="contest_id" value="" required />

                </form>
{{--
                <textarea onkeyup="$('input[name=description]').val($(this).val())" id="" cols="30" rows=""
                    class="form-control" placeholder="Describe your submission here"></textarea> --}}

                <!-- Button -->
                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                    form="apply-now-form" id="upload-image-button">
                    Submit Now <i class="icon-material-outline-arrow-right-alt"></i>
                </button>

            </div>

        </div>
    </div>
</div>

<div id="upload-file-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs dialog">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab">Upload Files</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Welcome Text -->
                <div class="welcome-text d-none">
                    <h3>Upload Files</h3>
                </div>

                <form action="{{ route('contests.submission.comment', ['slug' => $contest->slug, 'submission' => $submission->id]) }}" method="POST"
                    id="upload-file-form" class="dropzone mb-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="contest_id" id="contest_id" value="" required />

                </form>
                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                    form="apply-now-form" id="upload-file-button">
                    Submit Now <i class="icon-material-outline-arrow-right-alt"></i>
                </button>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="submissionPreviewModal" tabindex="-1" aria-labelledby="submissionPreviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="#" alt="" style="object-fit: contain;max-height: 70vh">
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="commentFileModal" tabindex="-1" aria-labelledby="commentFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="" alt="" style="max-height: 75vh">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_scripts')
    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        const offerImageDropzone = new Dropzone("#upload-image-form", {
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 5,
            uploadMultiple: true,
            paramName: 'images',
            acceptedFiles: 'image/*',
            maxFiles: 5,
            dictRemoveFileConfirmation: 'Are you sure you want to remove this file',
            dictDefaultMessage: '<h1 class="icon-feather-upload-cloud" style="color: orange;"></h1><p>Drop files here to upload!</p>'
        })

        offerImageDropzone.on('addedfile', (file) => {
            file.previewElement.addEventListener('click', () => {
                preview_image_modal.find('img').attr({
                    src: file.dataURL
                })
                preview_image_modal.modal('show')
            })
        })

        offerImageDropzone.on('totaluploadprogress', (progress) => {
            console.log('Progress: ', progress);
            // $('#upload-progress').attr({
            //     'aria-valuenow': progress
            // }).css({
            //     width: `${progress}%`
            // })
            // if(progress >= 100) {
            //     $('#upload-progress').removeClass('bg-warning').addClass('bg-success')
            // }
        })

        offerImageDropzone.on('queuecomplete', () => {
            console.log("All files have been uploaded successfully");
            // offerImageDropzone.reset()
            offerImageDropzone.removeAllFiles()
        })

        offerImageDropzone.on('error', (file, errorMessage, xhrError) => {
            console.log("Error occurred here: ", file, errorMessage, xhrError);
            Snackbar.show({
                text: errorMessage.message,
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 5000,
                textColor: '#fff',
                backgroundColor: '#721c24'
            });
            loading_container.hide()
        })

        offerImageDropzone.on('success', (file, successMessage, xhrError) => {
            console.log("Error occurred here: ", file, successMessage, xhrError);
            Snackbar.show({
                text: "Uploaded successfully.",
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 10000,
                textColor: '#fff',
                backgroundColor: '#28a745'
            });
            setTimeout(() => {
                window.location.reload()
            }, 5000);
        })

        $('#upload-image-button').on('click', () => {
            // $('#upload-progress').attr({
            //     'aria-valuenow': 0
            // }).css({
            //     width: `0%`
            // }).removeClass('bg-warning').addClass('bg-success')
            if (offerImageDropzone.getQueuedFiles() < 1) {
                Snackbar.show({
                    text: "You need to add at least 1 file for submission.",
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }
            loading_container.show()
            offerImageDropzone.processQueue()
        })

        const offerFileDropzone = new Dropzone("#upload-file-form", {
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 5,
            uploadMultiple: true,
            paramName: 'files',
            // acceptedFiles: 'image/*',
            maxFiles: 5,
            dictRemoveFileConfirmation: 'Are you sure you want to remove this file',
            dictDefaultMessage: '<h1 class="icon-feather-upload-cloud" style="color: orange;"></h1><p>Drop files here to upload!</p>'
        })

        offerFileDropzone.on('addedfile', (file) => {
            file.previewElement.addEventListener('click', () => {
                preview_image_modal.find('img').attr({
                    src: file.dataURL
                })
                preview_image_modal.modal('show')
            })
        })

        offerFileDropzone.on('totaluploadprogress', (progress) => {
            console.log('Progress: ', progress);
            // $('#upload-progress').attr({
            //     'aria-valuenow': progress
            // }).css({
            //     width: `${progress}%`
            // })
            // if(progress >= 100) {
            //     $('#upload-progress').removeClass('bg-warning').addClass('bg-success')
            // }
        })

        offerFileDropzone.on('queuecomplete', () => {
            console.log("All files have been uploaded successfully");
            // offerFileDropzone.reset()
            offerFileDropzone.removeAllFiles()
        })

        offerFileDropzone.on('error', (file, errorMessage, xhrError) => {
            console.log("Error occurred here: ", file, errorMessage, xhrError);
            Snackbar.show({
                text: errorMessage.message,
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 5000,
                textColor: '#fff',
                backgroundColor: '#721c24'
            });
            loading_container.hide()
        })

        offerFileDropzone.on('success', (file, successMessage, xhrError) => {
            console.log("Error occurred here: ", file, successMessage, xhrError);
            Snackbar.show({
                text: "Uploaded successfully.",
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 10000,
                textColor: '#fff',
                backgroundColor: '#28a745'
            });
            setTimeout(() => {
                window.location.reload()
            }, 5000);
        })

        $('#upload-file-button').on('click', () => {
            // $('#upload-progress').attr({
            //     'aria-valuenow': 0
            // }).css({
            //     width: `0%`
            // }).removeClass('bg-warning').addClass('bg-success')
            if (offerFileDropzone.getQueuedFiles() < 1) {
                Snackbar.show({
                    text: "You need to add at least 1 file for submission.",
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }
            loading_container.show()
            offerFileDropzone.processQueue()
        })

    </script>

    <script>
        const add_comment_button = $("#add-comment-button")
        add_comment_button.on('click', function() {
            // loading_container.show();

            let comment_input = $("textarea[name=comment]")

            if (comment_input.val().trim() == "") {
                Snackbar.show({
                    text: "Please enter a valid comment.",
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                return
            }

            // console.log(comment_input.val())
            // return
            loading_container.show()

            fetch(`${webRoot}contests/{{ $contest->slug }}/comment/submissions/{{ $submission->id }}`, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        _token,
                        comment: comment_input.val(),
                    })
                }).then(response => response.json())
                .then(async responseJson => {
                    if (responseJson.success) {
                        // console.log("Success here", responseJson);
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: 'green'
                        });
                        setTimeout(() => {
                            // loading_container.hide();
                            window.location.reload();
                        }, 2000)
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
                        loading_container.hide();
                    }
                })
                .catch(error => {
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
                })
        })

        $(".comment-file").on('click', function(e) {
            let src = $(e.target).attr('src')

            $("#commentFileModal").find('img').attr({src: src})
            $("#commentFileModal").modal('show')
        })

        $(".submission-thumbnail").on('click', function(e) {
            let this_submission = $(e.target)
            selected_submission_file = this_submission.data('file')
            selected_submission_username = this_submission.data('username')

            $("#submissionPreviewModal").find('img').attr({
                src: this_submission.attr('src')
            })
            $("#submissionPreviewModal").modal('show')
        })
    </script>
@endsection
