@extends('admin.layouts.app')

@section('page_content')
<div class="row">

    <!-- Dashboard Box -->
    <div class="col-xl-12">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3><i class="icon-material-outline-assignment"></i> Contest Categories</h3>
                <button href="#add-category-popup" class="mark-as-read ripple-effect-dark full-width popup-with-zoom-anim" title="Add new category" data-tippy-placement="left">
                    <i class="icon-feather-plus"></i>
                </button>
            </div>

            <div class="content">
                <ul class="dashboard-box-list">
                    @foreach ($categories as $category)
                        <li>
                            <div class="job-listing">
                                <div class="job-listing-details">
                                    <a href="{{ route('admin.contests.categories.show', ['id' => $category->id]) }}" class="job-listing-company-logo">
                                        {{-- <img src="{{ asset('_home/images/company-logo-02.png') }}" alt=""> --}}
                                        <img src="{{ asset('storage/category-icons/'.$category->icon) }}" alt="">
                                    </a>
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">
                                            <a href="{{ route('admin.contests.categories.show', ['id' => $category->id]) }}">
                                                {{ $category->title }}
                                            </a>
                                        </h3>
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li>
                                                    <i class="icon-material-outline-business"></i>
                                                    {{ $category->contest_sub_categories->count() }} Sub Categories
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="buttons-to-right">
                                {{-- <a href="{{ route('admin.contests.categories.show', ['id' => $category->id]) }}" class="button green ripple-effect ico" title="Manage" data-tippy-placement="left">
                                    <i class="icon-feather-edit"></i>
                                </a> --}}
                                <a href="#edit-sub-category-popup-{{ $category->id }}"  class="button green ripple-effect ico ico popup-with-zoom-anim" title="Manage" data-tippy-placement="left">
                                    <i class="icon-feather-edit"></i>
                                </a>
                                <a href="#" class="button red ripple-effect ico delete-category" title="Remove" data-tippy-placement="left" data-id="{{ $category->id }}">
                                    <i class="icon-feather-trash-2"></i>
                                </a>
                            </div>
                        </li>

                        <form action="{{ route('admin.contests.categories.delete', ['id' => $category->id]) }}" method="post" id="delete-category-{{ $category->id }}" class="d-none">
                            @csrf
                            @method('delete')
                            <button type="submit">Submit</button>
                        </form>

                        <div id="edit-sub-category-popup-{{ $category->id }}" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
                            <div class="sign-in-form">

                                <ul class="popup-tabs-nav">
                                    <li><a>Edit Contest Category</a></li>
                                </ul>

                                <div class="popup-tabs-container">

                                    <!-- Tab -->
                                    <div class="popup-tab-content" id="tab">

                                        <!-- Form -->
                                        <form method="post" action="{{ route('admin.contests.categories.update', $category->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            {{-- @method('put') --}}
                                            <input type="hidden" name="category_id" value="{{ $category->id }}">

                                            <input class=" with-border default margin-bottom-20" name="title" placeholder="Category Title" value="{{ $category->title }}" required />

                                            {{-- <input type="number" class=" with-border default margin-bottom-20" name="base_amount" placeholder="Base Amount" value="{{ $category->base_amount }}" required /> --}}

                                            <div class="uploadButton margin-top-0">
                                                <input class="uploadButton-input" type="file" accept="image/*" id="upload" name="icon"/>
                                                <label class="uploadButton-button ripple-effect" for="upload">Upload Contest Category Image</label>
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
                Contest Categories
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
                    @foreach ($categories as $category)
                        <tr>
                            <td class="d-none">
                                {{ $category->created_at }}
                            </td>
                            <td>
                                {{ $category->title }}
                            </td>
                            <td>
                                {{ $category->created_at->diffForHumans() }}
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
                <li><a>Create Category</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Form -->
                    <form method="POST" action="{{ route('admin.contests.categories.index') }}" enctype="multipart/form-data">
                        @csrf

                        <label for="" style="color: black">Category Title</label>
                        <input class=" with-border default margin-bottom-20" name="title" title="Priority" placeholder="" required />

                        <label for="" style="color: black">Icon</label>
                        <input type="file" class=" with-border default margin-bottom-20" name="icon" title="Priority" required accept="image/*" />

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
