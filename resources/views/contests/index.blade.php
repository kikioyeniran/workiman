@extends('layouts.app')

@section('page_title', 'Browse Contests')

@section('page_styles')
    <style type="text/css">
        .contests-banner {
            background-image: url("{{ asset('images/banners/graphic-design.jpg') }}");
            background-size: cover;
            background-position: center;
            margin-bottom: 50px;
        }

        .contests-banner-inner {
            padding: 70px 0 70px;
            background: rgba(0, 0, 0, .7);
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
                <h1 class="text-white mb-0">
                    Search Active Contests
                </h1>
                <form action="{{ route('search') }}" method="get">
                    <div class="intro-banner-search-form margin-top-70">
                        <div class="intro-search-field with-autocomplete">
                            <label for="autocomplete-input" class="field-title ripple-effect">Enter Contest Keywords</label>
                            <div class="input-with-icon">
                                <input name="keyword" type="text"
                                    placeholder="E.g Logo design, Letter head, Envelope design" required
                                    value="{{ $search_keyword }}">
                                <i class="icon-material-outline-location-on"></i>
                            </div>
                        </div>

                        <div class="intro-search-field">
                            <label for="intro-keywords" class="field-title ripple-effect">
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

                        <div class="intro-search-button">
                            <button class="button ripple-effect" type="submit">Search</button>
                        </div>
                    </div>
                </form>
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

                <div class="notify-box margin-top-15 d-none">
                    <div class="switch-container">
                        <label class="switch"><input type="checkbox"><span class="switch-button"></span><span
                                class="switch-text">Turn on email alerts for this search</span></label>
                    </div>

                    <div class="sort-by">
                        <span>Sort by:</span>
                        <select class="selectpicker hide-tick">
                            <option>Relevance</option>
                            <option>Newest</option>
                            <option>Oldest</option>
                            <option>Random</option>
                        </select>
                    </div>
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

    // alert("ds")

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
