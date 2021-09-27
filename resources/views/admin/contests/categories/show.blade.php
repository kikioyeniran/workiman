@extends('admin.layouts.app')

@section('page_content')
<div class="row">

    <!-- Dashboard Box -->
    <div class="col-xl-12">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3><i class="icon-material-outline-assignment"></i> {{ ucfirst($category->title) }}</h3>
                <button href="#add-sub-category-popup" class="mark-as-read ripple-effect-dark full-width popup-with-zoom-anim" title="Add sub category" data-tippy-placement="left">
                    <i class="icon-feather-plus"></i>
                </button>
            </div>

            <div class="content">
                <ul class="dashboard-box-list">
                    @foreach ($category->contest_sub_categories as $sub_category)
                        <li>

                            <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">
                                <img class="profile-pic" src="{{ asset($file_location.$sub_category->picture) }}" alt="" />
                            </div>
                            <div class="job-listing width-adjustment">
                                <div class="job-listing-details">
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">
                                            <a href="#">
                                                {{ ucfirst($sub_category->title) }}
                                            </a>
                                        </h3>

                                        <div class="job-listing-footer d-none">
                                            <ul>
                                                <li><i class="icon-material-outline-access-time"></i> 23 hours left</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul class="dashboard-task-info">
                                <li><strong>0</strong><span>Contests</span></li>
                                <li>
                                    <strong>
                                        ${{ number_format($sub_category->base_amount) }}
                                    </strong>
                                    <span>Base Amount</span>
                                </li>
                            </ul>

                            <div class="buttons-to-right always-visible">
                                <a href="#" class="button ripple-effect">
                                    <i class="icon-material-outline-visibility"></i> View Contests
                                </a>
                                <a href="#edit-sub-category-popup-{{ $sub_category->id }}" class="button gray ripple-effect ico popup-with-zoom-anim" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                <a href="#" class="button gray ripple-effect ico delete-sub-category" data-id="{{ $sub_category->id }}" title="Remove" data-tippy-placement="top">
                                    <i class="icon-feather-trash-2"></i>
                                </a>
                            </div>
                        </li>

                        <form action="{{ route('admin.contests.categories.sub-category') }}" method="post" id="delete-sub-category-{{ $sub_category->id }}" class="d-none">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="sub_category_id" value="{{ $sub_category->id }}" required>
                            <button type="submit">Submit</button>
                        </form>

                        <div id="edit-sub-category-popup-{{ $sub_category->id }}" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
                            <div class="sign-in-form">

                                <ul class="popup-tabs-nav">
                                    <li><a>Edit Sub Category</a></li>
                                </ul>

                                <div class="popup-tabs-container">

                                    <!-- Tab -->
                                    <div class="popup-tab-content" id="tab">

                                        <!-- Form -->
                                        <form method="post" action="{{ route('admin.contests.categories.sub-category') }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="sub_category_id" value="{{ $sub_category->id }}">

                                            <input class=" with-border default margin-bottom-20" name="title" placeholder="Category Title" value="{{ $sub_category->title }}" required />

                                            <input type="number" class=" with-border default margin-bottom-20" name="base_amount" placeholder="Base Amount" value="{{ $sub_category->base_amount }}" required />

                                            <div class="uploadButton margin-top-0">
                                                <input class="uploadButton-input" type="file" accept="image/*" id="upload" name="picture"/>
                                                <label class="uploadButton-button ripple-effect" for="upload">Upload Sub Category Image</label>
                                                <span class="uploadButton-file-name">Maximum file size: 10 MB</span>
                                            </div>
                                            <!-- Button -->
                                            <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save <i class="icon-material-outline-arrow-right-alt"></i></button>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div id="add-sub-category-popup" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a>Create Sub Category</a></li>
            </ul>

            <div class="popup-tabs-container">
                <div class="popup-tab-content" id="tab">
                    <form method="post" action="{{ route('admin.contests.categories.sub-category') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category_id" value="{{ $category->id }}">

                        <input class=" with-border default margin-bottom-20" name="title" placeholder="Sub category title" required />

                        <input type="number" class=" with-border default margin-bottom-20" name="base_amount" placeholder="Base amount" required />

                        <div class="uploadButton margin-top-0">
                            <input class="uploadButton-input" type="file" accept="image/*" id="upload" name="picture"/>
                            <label class="uploadButton-button ripple-effect" for="upload">Upload Sub Category Image</label>
                            <span class="uploadButton-file-name">Maximum file size: 10 MB</span>
                        </div>

                        <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save <i class="icon-material-outline-arrow-right-alt"></i></button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('page_scripts')
    <script>
        $(document).ready(() => {
            $('table').DataTable({
                order: [[0, 'desc']]
            })
        })

        $(".delete-sub-category").on('click', function(e) {
            e.preventDefault()
            let cat_id = $(this).data('id')
            let submit_button = $('form#delete-sub-category-' + cat_id).find('button[type=submit]')
            submit_button.trigger('click')
        });
    </script>
@endsection
