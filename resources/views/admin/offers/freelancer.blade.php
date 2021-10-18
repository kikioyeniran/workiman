@extends('admin.layouts.app')

@section('page_content')
<div class="row">
    <div class="col-xl-3 col-md-4 d-none">
        @include("offers.project-manager.sidebar", ["categories" => $categories, 'filter_categories' =>
        $filter_categories, 'filter_keywords' => $filter_keywords])
    </div>
    <div class="col-xl-12 content-left-offset">

        <h3 class="page-title d-none">@yield('page_title')</h3>

        <div class="notify-boxs margin-top-15 d-flex justify-content-end align-items-center margin-bottom-20">
            <span>Sort by:</span>
            <select class="hide-tick margin-left-10" style="max-width: 200px" id="sort-options">
                <option {{ $request->sort == 'newest' ? 'selected' : '' }} value="newest">
                    Newest
                </option>
                <option {{ $request->sort == 'oldest' ? 'selected' : '' }} value="oldest">
                    Oldest
                </option>
                <option {{ $request->sort == 'price-highest' ? 'selected' : '' }} value="price-highest">
                    Price: Highest
                </option>
                <option {{ $request->sort == 'price-lowest' ? 'selected' : '' }} value="price-lowest">
                    Price: Lowest
                </option>
            </select>
        </div>

        <div class="listings-container compact-list-layout">
            @forelse ($offers as $offer)
                @if($offer->status == 'active')
                    {{-- @include("contests.contest_row", ["contest" => $contest]) --}}
                    @include("offers.project-manager.project-manager-offer-row", ["offer" => $offer])
                    <a href="{{ route('offers.project-managers.show', ['offer_slug' => $offer->slug]) }}"
                        class="job-listing d-none">
                        <div class="job-listing-details">
                            <div class="job-listing-company-logo listing-user-avatar">
                                @if (is_null($offer->user->avatar))
                                    <img src="{{ asset('images/user-avatar-placeholder.png') }}" alt="">
                                @else
                                    <img src="{{ asset("storage/avatars/{$offer->user->avatar}") }}" alt="">
                                @endif
                            </div>
                            <div class="job-listing-description">
                                <h3 class="job-listing-title">
                                    {{ $offer->title }}
                                </h3>
                                <div class="job-listing-footer">
                                    <ul class="text-small">
                                        <li class="d-none">
                                            <i class="icon-material-outline-business"></i>
                                            Hexagon
                                            <div class="verified-badge" title="Verified Employer"
                                                data-tippy-placement="top"></div>
                                        </li>
                                        <li>
                                            <i class="icon-material-outline-bookmark-border"></i>
                                            {{ $offer->sub_category->title }}
                                        </li>
                                        <li>
                                            <i class="icon-material-outline-business-center"></i>
                                            @if ($offer->minimum_designer_level == 0)
                                                Any designer can apply
                                            @else
                                                Only designers with minimum of {{ $offer->minimum_designer_level }}
                                                can
                                                apply
                                            @endif
                                        </li>
                                        <li>
                                            <i class="icon-material-outline-access-time"></i>
                                            {{ $offer->created_at->diffForHumans() }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <span class="bookmark-icon"></span>
                        </div>
                    </a>
                @endif

            @empty
                <div class="alert alert-info">
                    <small>
                        There are no offers available at the moment.
                    </small>
                </div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $offers->links() }}
        </div>

        <!-- Pagination -->
        <div class="row d-none">
            <div class="col-md-12">
                <!-- Pagination -->
                <div class="pagination-container margin-top-60 margin-bottom-60">
                    <nav class="pagination">
                        <ul>
                            <li class="pagination-arrow"><a href="#"><i
                                        class="icon-material-outline-keyboard-arrow-left"></i></a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#" class="current-page">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li class="pagination-arrow"><a href="#"><i
                                        class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Pagination / End -->

    </div>
</div>

    <div class="dashboard-box margin-top-0 d-none">
        <div class="headline">
            <h4>
                Offer Categories
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
                    <form method="POST" action="{{ route('admin.offers.categories.index') }}">
                        @csrf

                        <input class=" with-border default margin-bottom-20" name="title" title="Priority" placeholder="Category Title" required />

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
