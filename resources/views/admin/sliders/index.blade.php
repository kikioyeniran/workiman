@extends('admin.layouts.app')

@section('page_content')
<div class="row">

    <!-- Dashboard Box -->
    <div class="col-xl-12">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3><i class="icon-material-outline-assignment"></i> Homepage Slider Images</h3>
                <button href="#add-category-popup" class="mark-as-read ripple-effect-dark full-width popup-with-zoom-anim" title="Add new slider" data-tippy-placement="left">
                    <i class="icon-feather-plus"></i>
                </button>
            </div>

            <div class="content">
                <ul class="dashboard-box-list">
                    @foreach ($sliders as $slider)
                        {{-- <li>
                            <div class="job-listing">
                                <div class="job-listing-details">
                                    <a href="#" class="job-listing-company-logo">
                                        <img src="{{ asset($file_location.$slider->picture) }}" alt="">
                                    </a>
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">
                                            <a href="#">
                                                {{ $slider->title }}
                                            </a>
                                        </h3>
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li>
                                                    <i class="icon-material-outline-business"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="buttons-to-right">
                                <a href="#" class="button green ripple-effect ico" title="Manage" data-tippy-placement="left">
                                    <i class="icon-feather-edit"></i>
                                </a>
                                <a href="#" class="button red ripple-effect ico delete-category" title="Remove" data-tippy-placement="left" data-id="{{ $slider->id }}">
                                    <i class="icon-feather-trash-2"></i>
                                </a>
                            </div>
                        </li> --}}
                        <li>

                            <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">
                                <img class="profile-pic" src="{{ asset($file_location.$slider->picture) }}" alt="" />
                            </div>
                            <div class="job-listing width-adjustment">
                                <div class="job-listing-details">
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">
                                            <a href="#" style="color: #e09426;">
                                                {{ ucfirst($slider->large_text) }}
                                            </a>
                                        </h3>
                                        <h3 class="job-listing-title">
                                            <a href="#">
                                                {{ ucfirst($slider->small_text) }}
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

                            {{-- <ul class="dashboard-task-info">
                                <li><strong>0</strong><span>Contests</span></li>
                                <li>
                                    <strong>
                                        ${{ number_format($slider->base_amount) }}
                                    </strong>
                                    <span>Base Amount</span>
                                </li>
                            </ul> --}}

                            <div class="buttons-to-right always-visible">
                                <a href="#edit-sub-category-popup-{{ $slider->id }}" class="button gray ripple-effect ico popup-with-zoom-anim" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                <a href="{{ route('admin.sliders.disable', $slider->id) }}" class="button gray ripple-effect ico delete-sub-category" data-id="{{ $slider->id }}" title="Remove" data-tippy-placement="top">
                                    <i class="icon-feather-trash-2"></i>
                                </a>
                            </div>
                        </li>

                        {{-- <form action="{{ route('admin.sliders.delete', ['id' => $slider->id]) }}" method="post" id="delete-category-{{ $slider->id }}" class="d-none"> --}}
                        <form action="#" method="post" id="delete-category-{{ $slider->id }}" class="d-none">
                            @csrf
                            @method('delete')
                            <button type="submit">Submit</button>
                        </form>

                        <div id="edit-sub-category-popup-{{ $slider->id }}" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
                            <div class="sign-in-form">

                                <ul class="popup-tabs-nav">
                                    <li><a>Edit Slider</a></li>
                                </ul>

                                <div class="popup-tabs-container">

                                    <!-- Tab -->
                                    <div class="popup-tab-content" id="tab">

                                        <!-- Form -->
                                        <form method="post" action="{{ route('admin.sliders.update', $slider->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="slider_id" value="{{ $slider->id }}">

                                            <input class=" with-border default margin-bottom-20" name="large_text" placeholder="Slider Colored Text" value="{{ $slider->large_text }}" required />

                                            <input class=" with-border default margin-bottom-20" name="small_text" placeholder="Slider Small Text" value="{{ $slider->small_text }}" required />

                                            {{-- <input type="number" class=" with-border default margin-bottom-20" name="base_amount" placeholder="Base Amount" value="{{ $slider->base_amount }}" required /> --}}

                                            <div class="uploadButton margin-top-0">
                                                <input class="uploadButton-input" type="file" accept="image/*" id="upload" name="picture"/>
                                                <label class="uploadButton-button ripple-effect" for="upload">Upload Slider Image</label>
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

</div>

    <div class="dashboard-box margin-top-0 d-none">
        <div class="headline">
            <h4>
                Contest sliders
            </h4>
            <button href="#add-category-popup" class="mark-as-read ripple-effect-dark full-width popup-with-zoom-anim" title="Add new category" data-tippy-placement="left">
                <i class="icon-feather-plus"></i>
            </button>
        </div>
        <div class="content padding-top-20 padding-left-20 padding-right-20 padding-bottom-20">
            <table class="table">
                <thead>
                    <tr>
                        <th class="d-none"></th>
                        <th>
                            Title
                        </th>
                        <th>
                            Date Added
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                        <tr>
                            <td class="d-none">
                                {{ $slider->created_at }}
                            </td>
                            <td>
                                {{ $slider->large_text }}
                            </td>
                            <td>
                                {{ $slider->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <button class="btn btn-info">Add Sub Cateogry</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="add-category-popup" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a>Create Slider</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Form -->
                    <form method="POST" action="{{ route('admin.sliders.index') }}" enctype="multipart/form-data">
                        @csrf

                        <label for="" style="color: black">Colored Text</label>
                        <input class=" with-border default margin-bottom-20" name="large_text" title="Priority" placeholder="" required />

                        <label for="" style="color: black">Small Text</label>
                        <input class=" with-border default margin-bottom-20" name="small_text" title="Priority" placeholder="" required />

                        <label for="" style="color: black">Image</label>
                        <input type="file" class=" with-border default margin-bottom-20" name="picture" title="Priority" required accept="image/*" />

                        <!-- Button -->
                        <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save <i class="icon-material-outline-arrow-right-alt"></i></button>

                    </form>
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

        $(".delete-category").on('click', function(e) {
            e.preventDefault()
            let cat_id = $(this).data('id')
            let submit_button = $('form#delete-category-' + cat_id).find('button[type=submit]')
            submit_button.trigger('click')
        });
    </script>
@endsection
