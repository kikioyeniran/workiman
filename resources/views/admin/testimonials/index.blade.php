@extends('admin.layouts.app')

@section('page_content')
<div class="row">

    <!-- Dashboard Box -->
    <div class="col-xl-12">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3><i class="icon-material-outline-assignment"></i> Testimonials </h3>
                <button href="#add-category-popup" class="mark-as-read ripple-effect-dark full-width popup-with-zoom-anim" title="Add new slider" data-tippy-placement="left">
                    <i class="icon-feather-plus"></i>
                </button>
            </div>

            <div class="content">
                <ul class="dashboard-box-list">
                    @foreach ($testimonials as $testimonial)
                        <li>

                            <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">
                                <img class="profile-pic" src="{{ asset($file_location.$testimonial->picture) }}" alt="" />
                            </div>
                            <div class="job-listing width-adjustment">
                                <div class="job-listing-details">
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">
                                            <a href="#" style="color: #e09426;">
                                                {{ ucfirst($testimonial->name) }}  - {{ $testimonial->portfolio }}
                                            </a>
                                        </h3>
                                        <h3 class="job-listing-title">
                                            <a href="#">
                                                {{ ucfirst($testimonial->testimony) }}
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

                            <div class="buttons-to-right always-visible">
                                <a href="#edit-sub-category-popup-{{ $testimonial->id }}" class="button gray ripple-effect ico popup-with-zoom-anim" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                <a href="{{ route('admin.sliders.disable', $testimonial->id) }}" class="button gray ripple-effect ico delete-sub-category" data-id="{{ $testimonial->id }}" title="Remove" data-tippy-placement="top">
                                    <i class="icon-feather-trash-2"></i>
                                </a>
                            </div>
                        </li>

                        {{-- <form action="{{ route('admin.sliders.delete', ['id' => $testimonial->id]) }}" method="post" id="delete-category-{{ $testimonial->id }}" class="d-none"> --}}
                        <form action="#" method="post" id="delete-category-{{ $testimonial->id }}" class="d-none">
                            @csrf
                            @method('delete')
                            <button type="submit">Submit</button>
                        </form>

                        <div id="edit-sub-category-popup-{{ $testimonial->id }}" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
                            <div class="sign-in-form">

                                <ul class="popup-tabs-nav">
                                    <li><a>Edit Testimonial</a></li>
                                </ul>

                                <div class="popup-tabs-container">

                                    <!-- Tab -->
                                    <div class="popup-tab-content" id="tab">

                                        <!-- Form -->
                                        <form method="post" action="{{ route('admin.testimonials.update', $testimonial->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            {{-- <input type="hidden" name="slider_id" value="{{ $testimonial->id }}"> --}}

                                            <input class=" with-border default margin-bottom-20" name="name" placeholder="Testifier Name" value="{{ $testimonial->name }}" required />

                                            <input class=" with-border default margin-bottom-20" name="portfolio" placeholder="Testifier Portfolio (optional)" value="{{ $testimonial->portfolio }}" />

                                            <textarea name="testimony"  class="with-border default margin-bottom-20"  id="" cols="30" rows="5">{{ $testimonial->testimony }}</textarea>

                                            {{-- <input type="number" class=" with-border default margin-bottom-20" name="base_amount" placeholder="Base Amount" value="{{ $testimonial->base_amount }}" required /> --}}

                                            <div class="uploadButton margin-top-0">
                                                <input class="uploadButton-input" type="file" accept="image/*" id="upload" name="picture"/>
                                                <label class="uploadButton-button ripple-effect" for="upload">Upload Testifier Image</label>
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
                    @foreach ($testimonials as $testimonial)
                        <tr>
                            <td class="d-none">
                                {{ $testimonial->created_at }}
                            </td>
                            <td>
                                {{ $testimonial->large_text }}
                            </td>
                            <td>
                                {{ $testimonial->created_at->diffForHumans() }}
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
                <li><a>Create Testimonial</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Form -->
                    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
                        @csrf


                        {{-- <input class=" with-border default margin-bottom-20" name="large_text" title="Priority" placeholder="" required />

                        <label for="" style="color: black">Small Text</label>
                        <input class=" with-border default margin-bottom-20" name="small_text" title="Priority" placeholder="" required />

                        <label for="" style="color: black">Image</label>
                        <input type="file" class=" with-border default margin-bottom-20" name="picture" title="Priority" required accept="image/*" /> --}}

                        <label for="" style="color: black">Testifier Name</label>
                        <input class=" with-border default margin-bottom-20" name="name" placeholder="Testifier Name" required />

                        <label for="" style="color: black">Testifier Portfolio</label>
                        <input class=" with-border default margin-bottom-20" name="portfolio" placeholder="Testifier Portfolio (optional)"  />

                        <label for="" style="color: black">Details</label>
                        <textarea name="testimony"  class="with-border default margin-bottom-20"  id="" cols="30" rows="5"></textarea>

                        {{-- <input type="number" class=" with-border default margin-bottom-20" name="base_amount" placeholder="Base Amount" value="{{ $testimonial->base_amount }}" required /> --}}

                        <div class="uploadButton margin-top-0">
                            <input class="uploadButton-input" type="file" accept="image/*" id="upload" name="picture"/>
                            <label class="uploadButton-button ripple-effect" for="upload">Upload Testimonial Image</label>
                            <span class="uploadButton-file-name">Maximum file size: 10 MB</span>
                        </div>
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
