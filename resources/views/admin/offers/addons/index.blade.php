@extends('admin.layouts.app')

@section('page_content')
    <div class="row">
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">
                <div class="headline">
                    <h3><i class="icon-material-outline-assignment"></i> Contest Addons</h3>
                    <button href="#add-addon-popup" class="mark-as-read ripple-effect-dark full-width popup-with-zoom-anim" title="Add new addon" data-tippy-placement="left">
                        <i class="icon-feather-plus"></i>
                    </button>
                </div>

                <div class="content">
                    <ul class="dashboard-box-list">
                        @foreach ($addons as $addon)
                            <li>
                                <div class="job-listing">
                                    <div class="job-listing-details">
                                        <a href="#" class="job-listing-company-logo">
                                            <img src="{{ asset('_home/images/company-logo-02.png') }}" alt="">
                                        </a>
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">
                                                <a href="{{ route('admin.contests.categories.show', ['id' => $addon->id]) }}">
                                                    {{ $addon->title }}
                                                </a>
                                            </h3>
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li>
                                                        <i class="icon-material-outline-business"></i>
                                                        {{ $addon->description }}
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <i class="icon-material-outline-add-shopping-cart"></i>
                                                        <b>₦{{ number_format($addon->amount) }}</b>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="buttons-to-right">
                                    <a href="#edit-addon-popup-{{ $addon->id }}" class="button green ripple-effect ico popup-with-zoom-anim" title="Manage" data-tippy-placement="left">
                                        <i class="icon-feather-edit"></i>
                                    </a>
                                    <a href="#" class="button red ripple-effect ico delete-addon" title="Remove" data-tippy-placement="left" data-id="{{ $addon->id }}">
                                        <i class="icon-feather-trash-2"></i>
                                    </a>
                                </div>
                            </li>

                            <form action="#" method="post" id="delete-addon-{{ $addon->id }}" class="d-none">
                                @csrf
                                @method('delete')
                                <button type="submit">Submit</button>
                            </form>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="add-addon-popup" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
        <div class="sign-in-form">
            <ul class="popup-tabs-nav">
                <li><a>Create Addon</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Form -->
                    <form method="POST" action="{{ route('admin.contests.addons.index') }}">
                        @csrf
                        <input class=" with-border default margin-bottom-20" name="title" title="Title" placeholder="Addon Title" required />

                        <textarea class=" with-border default margin-bottom-20" name="description" title="Description" placeholder="Description" required ></textarea>

                        <input type="number" class=" with-border default margin-bottom-20" name="amount" title="Amount" placeholder="Amount" required />

                        <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save <i class="icon-material-outline-arrow-right-alt"></i></button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @foreach ($addons as $addon)
        <div id="edit-addon-popup-{{ $addon->id }}" class="zoom-anim-dialog mfp-hide dialog-with-tabs custom-popup">
            <div class="sign-in-form">
                <ul class="popup-tabs-nav">
                    <li><a>Create Addon</a></li>
                </ul>

                <div class="popup-tabs-container">

                    <!-- Tab -->
                    <div class="popup-tab-content" id="tab">

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.contests.addons.index', ['id' => $addon->id]) }}">
                            @csrf
                            @method('put')
                            <input class=" with-border default margin-bottom-20" name="title" value="{{ $addon->title }}" title="Title" placeholder="Addon Title" required />

                            <textarea class=" with-border default margin-bottom-20" name="description" title="Description" placeholder="Description" required >{{ $addon->description }}</textarea>

                            <input type="number" class=" with-border default margin-bottom-20" name="amount" value="{{ $addon->amount }}" title="Amount" placeholder="Amount" required />

                            <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save <i class="icon-material-outline-arrow-right-alt"></i></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('page_scripts')
    <script>
        $(document).ready(() => {
            $('table').DataTable({
                order: [[0, 'desc']]
            })
        })

        $(".delete-addon").on('click', function(e) {
            e.preventDefault()
            let addon_id = $(this).data('id')
            let submit_button = $('form#delete-addon-' + addon_id).find('button[type=submit]')
            submit_button.trigger('click')
        });
    </script>
@endsection
