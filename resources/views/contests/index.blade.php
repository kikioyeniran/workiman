@extends('layouts.app')

@section('page_title', 'Browse Contests')

@section('page_styles')
    <style type="text/css">
        .contests-banner {
            background-image: url("{{ asset('images/banners/1.png') }}");
            margin-bottom: 20px;
        }

        .contests-banner-inner {
            background-color: transparent;
            color: black !important;
        }

        .each-contest-tag {
            background-color: grey;
            padding: 2px 10px 3px;
            border-radius: 3px;
            color: white;
            font-size: small;
            margin-right: 3px;
        }

        @media (min-width: 1367px) {
            .container {
                max-width: 1210px;
            }
        }

    </style>
@endsection

@section('page_content')
    {{-- <div class="margin-top-50"></div> --}}
    <div class="contests-banner">
        <div class="contests-banner-inner">
            <div class="container">
                <h1 class="text-black mb-0">
                    Search Active Contests
                </h1>
                <form action="{{ route('search') }}" method="get">
                    <div class="intro-banner-search-form">
                        <div class="intro-search-field with-autocomplete">
                            <label for="autocomplete-input" class="field-title ripple-effect d-none d-sm-flex">Enter Contest
                                Keywords</label>
                            <div class="input-with-icon">
                                <input name="keyword" type="text"
                                    placeholder="E.g Logo design, Letter head, Envelope design" required
                                    value="{{ $search_keyword }}">
                                <i class="icon-material-outline-location-on"></i>
                            </div>
                        </div>

                        <div class="intro-search-field">
                            <label for="intro-keywords" class="field-title ripple-effect d-none d-sm-flex">
                                Select a Category
                            </label>
                            {{-- <input id="intro-keywords" type="text" placeholder="Job Title or Keywords"> --}}
                            <input name="category" type="hidden" value="contests" />
                            <select name="contest_category">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, $filter_categories) ? 'selected' : '' }}>
                                        {{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="intro-search-button mt-3 mt-sm-0 mr-0 mr-sm-2 mb-0">
                            <button class="button ripple-effect" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                @if (count($tag_suggestions))
                    <div class="mt-2 d-flex align-items-center flex-wrap">
                        <div class="mr-1">
                            <small class="text-black">
                                Popular Tags:
                            </small>
                        </div>
                        <div class="">
                            @foreach ($tag_suggestions as $tag)
                                <a href="{{ route('search', ['keyword' => $tag, 'category' => 'contests']) }}">
                                    <span class="each-contest-tag">{{ $tag }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container pb-5">
        <div class="row">
            <div class="col-xl-3 col-lg-4 d-none">
                @include("contests.sidebar", ["categories" => $categories, 'filter_categories' => $filter_categories,
                'filter_keywords' => $filter_keywords])
            </div>
            <div class="col-xl-12 content-left-offset">

                {{-- <h3 class="page-title">@yield('page_title')</h3> --}}

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

                <div class="listings-container compact-list-layout margin-top-10">
                    @forelse ($contests as $contest)
                        @include("contests.contest_row", ["contest" => $contest])
                    @empty
                        <div class="alert alert-info">
                            <small>
                                There are no contests available at the moment.
                            </small>
                        </div>
                    @endforelse
                </div>

                <div class="mt-3">
                    {{ $contests->links() }}
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
    </div>
@endsection

@section('page_scripts')
<script type="text/javascript">
    const contests_filter = $(".contests-filter")

    const sort_options = $("#sort-options")
    const page_url = `{{ ROute::current()->uri }}`
    const page_url_parameters = JSON.parse(`{!! json_encode($request->all()) !!}`)

    sort_options.on("change", function(e) {
        let sort_by = sort_options.val()

        // Add sort from URL
        page_url_parameters.sort = sort_by

        let new_url = `${webRoot}${page_url}?`

        let first_param = true
        for (const key in page_url_parameters) {
            if (Object.hasOwnProperty.call(page_url_parameters, key)) {
                const element = page_url_parameters[key];
                new_url += `${!first_param ? '&' : ''}${key}=${element}`
                first_param = false
            }
        }

        window.location.href = new_url
    })

    contests_filter.on("change", function(e) {
        // let filter = $(e.target).data('filter')
        filterContests()
    })

    $('body').on('DOMSubtreeModified', '#contest-keywords-list', function() {
        filterContests()
    });

    function filterContests() {
        let filters, keyword = []

        let keyword_texts = $("#contest-keywords-list").find(".keyword-text")

        $.each($("#contest-keywords-list").find(".keyword-text"), (key, val) => {
            keyword.push($(val).text())
        })


        let payload = {
            _token,
            keyword: keyword
        }

        $.each(contests_filter, (key, filter) => {
            payload[$(filter).data('filter')] = $(filter).val()
        })

        console.log(payload)

        loading_container.show();

        fetch(`${webRoot}/contests/filter`, {
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
                    setTimeout(() => {
                        window.location = responseJson.redirect_url;
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
                    $('html, body').animate({
                        scrollTop: $('#wrapper').offset().top
                    }, 500);
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
                $('html, body').animate({
                    scrollTop: $('#wrapper').offset().top
                }, 500);
            })
    }
</script>
@endsection
