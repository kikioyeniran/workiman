@extends('layouts.app')

@section('page_styles')
    <style type="text/css">
        .add-on-each {
            box-shadow: 1px 5px 15px 5px #f0f0f0;
            border-color: #f0f0f0;
            margin-bottom: 20px;
            cursor: pointer;
            background-color: #fff;
            border-radius: 3px;
            transition: .2s all ease;
        }
        .add-on-each:hover {
            background-color: #e09426;
            color: #fff;
        }
        .add-on-each {
            padding: 10px 10px;
        }
        .add-on-each .add-on-title {
            font-weight: bold;
            font-size: small;
        }
        .add-on-each .add-on-description {
            font-size: smaller;
            margin-top: 5px;
        }
        .add-on-each .add-on-price {
            /* font-size: small; */
            font-weight: bold;
        }
        #prize_money > div {
            display: none;
        }
    </style>
@endsection

@section('page_content')
    <div class="single-page-header create-contest-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="headline">
                        <h1>Create a contest</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">

                        {{-- <form action="/upload-target" class="dropzone">
                            @csrf
                        </form> --}}
                    {{-- <form action="#" method="post" name="job_form" enctype="multipart/form-data"> --}}
                        @csrf
                        <div class="content with-padding padding-bottom-10">
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="submit-field">
                                        <h5>Contest Title</h5>
                                        <input type="text" class="with-border tippy" value="" placeholder="Contest Title" name="title">
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Contest Category</h5>
                                        <select class="with-border category-input" name="category" data-placeholder="Select Category" >
                                            <option value="">-</option>
                                            @foreach ($categories as $category)
                                                <optgroup label="{{ $category->title }}">
                                                    @foreach ($category->contest_sub_categories as $sub_category)
                                                        <option value="{{ $sub_category->id }}" data-baseamount="{{ $sub_category->base_amount }}">{{ $sub_category->title }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>Contest Description</h5>
                                        <textarea cols="30" rows="5" name="description" class="with-border tippy" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet blanditiis nemo nobis placeat. Atque, doloribus esse eveniet fuga fugiat illum ipsa labore magni molestiae mollitia nemo obcaecati totam unde ut."></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-12 mb-4">
                                    <form action="{{ route('contests.images') }}" method="POST" id="contest-images-form" class="dropzone" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="contest_id" id="contest_id" value="" required />
                                    </form>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <div class="row">
                                            <div class="col-xl-6 col-xs-12">
                                                <h5>Designer Level</h5>
                                                <select class="with-border tippy" name="designer_level" data-placeholder="No of designers">
                                                    <option value="">-</option>
                                                    <option value="0">Anybody can apply</option>
                                                    <option value="3">Minimum of 3 stars</option>
                                                    <option value="5">5 stars</option>
                                                </select>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="col-xl-6 col-xs-12">
                                                <h5>Possible Winners</h5>
                                                <select class="with-border tippy" name="possible_winners" data-placeholder="No of winners">
                                                    {{-- <option value="">-</option> --}}
                                                    @for ($i = 1; $i <= 3; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <div class="clearfix"></div>
                                                <div class="prizes" id="prize_money">
                                                    <div id="first_place_container">
                                                        <label>1st Place</label>
                                                        <input type="text" class="with-border" value="" name="first_place">
                                                    </div>
                                                    <div id="second_place_container">
                                                        <label>2nd Place</label>
                                                        <input type="text" class="with-border" value="" name="second_place">
                                                    </div>
                                                    <div id="third_place_container">
                                                        <label>3rd Place</label>
                                                        <input type="text" class="with-border" value="" name="third_place">
                                                    </div>
                                                    <div class="pos-warning"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>Contest Add-Ons</h5>
                                        <div class="row add-on-list">
                                            @foreach ($addons as $addon)
                                                <div class="col-sm-6">
                                                    <div class="add-on-each">
                                                        <div class="row">
                                                            <div class="col-2 col-sm-1">
                                                                <div class="switch-container m-0">
                                                                    <label class="switch">
                                                                        <input type="checkbox" name="addon[]" class="contest-addon ad" data-amount="{{ $addon->amount }}" data-id="{{ $addon->id }}" value="yes">
                                                                        <span class="switch-button"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 col-sm-9">
                                                                <div class="add-on-title">
                                                                    {{ $addon->title }}
                                                                </div>
                                                            </div>
                                                            <div class="col-3 col-sm-2 pr-0 pr-sm-3 text-right">
                                                                <div class="add-on-price">
                                                                    @if ($addon->amount)
                                                                        ${{ number_format($addon->amount) }}
                                                                    @else
                                                                        Free
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-10 offset-2 col-sm-11 offset-sm-1">
                                                                <div class="add-on-description">
                                                                    {{ $addon->description }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 nda-form mb-4" style="display: none;" id="nda-form">
                                    {{-- <input type="hidden" name="nda" value="0"> --}}
                                    <h4>Non-Disclosure Agreement</h4>
                                    <p>You selected the Non-disclosure Agreement add on, do you want to use our <a href="#">Non-Disclosure Agreement</a> or write your own in the box below.</p>
                                    <textarea name="nda" id="" class="with-border" rows="5" placeholder="Write Non-Disclosure Agreement here"></textarea>
                                    <div class="container">
                                    </div>
                                </div>

                                <div class="col-xl-5">
                                    <div class="submit-field">
                                        <h5>Budget (NGN)</h5>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <input type="number" class="budget budget-input" placeholder="0,000" name="budget">
                                                <span style="color: #666; font-size: 12px;">The system won't process amount less than the estimated budget</span><br>
                                                <span style="color: green; clear:both; font-size: 12px;">You can increase your budget later to attract more designers.</span>
                                                <input type="hidden" class="min_budget" name="minimum_budget">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="submit-field">
                                        <h5>Duration (Days)</h5>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <input type="number" class="" value="7" name="duration" min="3" max="7">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-5">
                                    <div class="submit-field">
                                        <h5>Tags <span>(optional)</span>  <i class="help-icon tippy" data-tippy-placement="right" title="Maximum of 10 tags"></i></h5>
                                        <div class="keywords-container">
                                            <div class="keyword-input-container">
                                                <input type="text" class="keyword-input with-border" value="" name="tags" placeholder="e.g. Contest title, responsibilites"/>
                                            </div>
                                            <div class="keywords-list"><!-- keywords go here --></div>
                                            <div class="clearfix"></div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
            </div>

            <div class="col-xl-12 mb-5">
                <a href="javascript:void(0);" class="button ripple-effect uplNext big margin-top-30" id="submit-contest-form"><i class="icon-feather-plus"></i> Create Contest</a>
                <div class="upload-notice"></div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('js/contest-dropzone.js') }}?{{ time() }}"></script>
    <script type="text/javascript">
        const submit_contest_form_btn = $('#submit-contest-form');
        const tag_keywords_list = $('.keywords-list')
        const nda_form = $('#nda-form')

        const title_input = $('input[name=title]')
        const category_select = $('select[name=category]')
        const description_textarea = $('textarea[name=description]')
        const designer_level_select = $('select[name=designer_level]')
        const possible_winners_select = $('select[name=possible_winners]')
        const budget_input = $('input[name=budget]')
        const duration_input = $('input[name=duration]')
        const contest_addon = $('input.contest-addon[type=checkbox]')
        const nda = $('textarea[name=nda]')

        const first_place_container = $('#first_place_container')
        const second_place_container = $('#second_place_container')
        const third_place_container = $('#third_place_container')

        const first_place_input = $('input[name=first_place_input]')
        const second_place_input = $('input[name=second_place_input]')
        const third_place_input = $('input[name=third_place_input]')

        let title = ''
        let category = ''
        let description = ''
        let designer_level = ''
        let possible_winners = 1
        let budget = 0
        let duration = 0
        let tags
        let addons

        category_select.on('change', () => {
            refreshBudget()
        })

        contest_addon.on('change', (e) => {
            let addon_id = $(e.target).data('id')

            refreshBudget()

            budget_input.val(budget)

            if(addon_id == 4) {
                if($(e.target).is(':checked')) {
                    nda_form.slideDown();
                } else {
                    nda_form.slideUp();
                }
            }
        })

        function refreshBudget() {
            budget = 0;

            if(category_select.val() != '') {
                let selected_category = category_select.find('option:selected')
                let base_amount = selected_category.data('baseamount')
                budget += base_amount
            }

            $.each(contest_addon, (key, val) => {
                let addon_amount = $(val).data('amount')

                if($(val).is(':checked')) {
                    budget += addon_amount
                    console.log(val, "is checked");

                }
            })

            budget_input.val(budget)
        }

        possible_winners_select.on('change', e => {

            switch ($(e.target).val()) {
                case '3':
                    first_place_container.slideDown()
                    second_place_container.slideDown()
                    third_place_container.slideDown()
                    break;
                case '2':
                    first_place_container.slideDown()
                    second_place_container.slideDown()
                    third_place_container.slideUp()
                    break;
                default:
                    first_place_container.slideUp()
                    second_place_container.slideUp()
                    third_place_container.slideUp()
                    break;
            }
        })

        submit_contest_form_btn.on('click', () => {
            loading_container.show();
            tags = [];
            addons = [];

            let payload = {
                title:  title_input.val().trim(),
                category:  category_select.val(),
                description:  description_textarea.val().trim(),
                designer_level:  designer_level_select.val(),
                possible_winners:  possible_winners_select.val(),
                budget: budget_input.val().trim(),
                duration: duration_input.val().trim(),
                nda: $('input.contest-addon[type=checkbox][data-id=4]').is(':checked') ? nda.val().trim() : '',
            }

            // get selected addons
            $.each(contest_addon, (key, val) => {
                if($(val).is(':checked')) {
                    addons.push($(val).data('id'))
                }
            })

            // Get tags from input
            let tag_keywords = tag_keywords_list.find('span.keyword-text')

            $.each(tag_keywords, (key, val) => {
                // push each tag to tag array
                let tag_text = val.innerText
                tags.push(tag_text)
            })

            // Add tags to payload
            // make request to save contest
            payload = {...payload, _token, tags, addons}
            fetch(`{{ route('contests.store') }}`, {
                method: 'post',
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(payload)
            }).then(response => response.json())
            .then(async responseJson => {
                if(responseJson.success) {
                    console.log("Success here", responseJson);
                    $("#contest-images-form").find('input[name=contest_id]').val(responseJson.contest_id)
                    // Submit media for contest
                    await contestImagesDropzone.processQueue()
                    setTimeout(() => {
                        window.location = `{{ url('contests/payment') }}/${responseJson.contest_id}`;
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

                // return

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

        })
    </script>

@endsection
