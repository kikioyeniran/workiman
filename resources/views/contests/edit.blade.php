@extends('layouts.app')

@section('page_title', 'Edit Contest')

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

        #prize_money>div {
            display: none;
        }

        .fixed-budget {
            position: fixed;
            /* float: right; */
            /* right: 0; */
            left: 66%;
            top: 120px;
            z-index: 1000;
            width: 200px;
        }

        .sticky-budget {
            position: -webkit-sticky;
            position: sticky;
            top: 100px;
        }

        .budget-card .card {
            border: 0;
            box-shadow: 1px 5px 15px 5px #f0f0f0;
        }

        @media(max-width: 768px) {
            .fixed-budget {
                /* position: relative;
                    top: 0;
                    left: 0;
                    width: 100%;
                    margin-bottom: 20px; */
            }
        }

    </style>
@endsection

@section('page_content')
    <div class="single-page-header create-offer-header margin-bottom-40" style="background-image: url('{{ asset('images/banners/1.png') }}');">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="headline">
                        <h1>
                            <br>
                            <br>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="fixed-budget budget-card d-none d-sm-block">
            <div class="card">
                <div class="d-flex align-items-center flex-column card-body">
                    <h6>Budget ({{ auth()->user()->is_nigeria == true ? '₦' : '$' }})</h6>
                    {{-- <h1 class="budget-text">{{ auth()->user()->is_nigeria == true ? number_format($contest->budget * $dollar_rate) : number_format($contest->budget) }}</h1> --}}
                    <h1 class="budget-text">{{ number_format($contest->budget)}}</h1>
                </div>
            </div>
        </div>
        {{-- <form action="{{ route('offers.new') }}" method="post" name="job_form" enctype="multipart/form-data">
            @csrf --}}

        <h1 class=" margin-bottom-20">
            <small>
                Edit Contest - {{ $contest->title }}
            </small>
        </h1>
        <div class="row">
            <div class="col-sm-9">
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
                                    <input type="text" class="with-border tippy" value="{{ $contest->title }}" placeholder="Contest Title"
                                        name="title" disabled>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Contest Category</h5>
                                    <select class="with-border category-input" name="category"
                                        data-placeholder="Select Category" disabled>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <optgroup label="{{ $category->title }}">
                                                @foreach ($category->contest_sub_categories as $sub_category)
                                                    <option value="{{ $sub_category->id }}" data-baseamount="{{ $sub_category->base_amount }}" {{ $sub_category->id == $contest->sub_category_id ? 'selected' : '' }}>
                                                        {{ $sub_category->title }}</option>
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
                                    <textarea cols="30" rows="5" name="description" class="with-border tippy"
                                        placeholder="contest description here" disabled>{{ $contest->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-xl-12 mb-4">
                                <form action="{{ route('contests.images') }}" method="POST" id="contest-images-form"
                                    class="dropzone" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="contest_id" id="contest_id" value="" required />
                                </form>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <div class="row">
                                        <div class="col-xl-6 col-xs-12">
                                            <h5>Freelancer Level</h5>
                                            <select class="with-border tippy" name="designer_level"
                                                data-placeholder="No of designers">
                                                <option value="">Select Level</option>
                                                <option value="0"  {{ $contest->minimum_designer_level == '0' ? 'selected' : '' }}>Anybody can apply</option>
                                                {{-- <option value="3" {{ $contest->minimum_designer_level == '3' ? 'selected' : '' }}>Minimum of 3 stars</option>
                                                <option value="5" {{ $contest->minimum_designer_level == '5' ? 'selected' : '' }}>5 stars</option> --}}
                                            </select>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-xl-6 col-xs-12">
                                            <h5>Possible Winners</h5>
                                            <select class="with-border tippy" name="possible_winners"
                                                data-placeholder="No of winners">
                                                {{-- <option value="">-</option> --}}
                                                @for ($i = 1; $i <= 3; $i++)
                                                    <option value="{{ $i }}" {{ $i == $contest->possible_winners_count ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <div class="clearfix"></div>
                                            <div class="prizes" id="prize_money">
                                                {{-- @if($contest->possible_winners_count > 1) --}}
                                                <div id="first_place_container" style="{{ $contest->possible_winners_count >= 1 ? 'display: block' : '' }}">
                                                    <label>1st Place</label>
                                                    <input type="number" min="0" max="100" class="with-border" value="{{ $contest->possible_winners_count >= 1 ? $contest->first_place_prize : '' }}"
                                                        name="first_place" placeholder="%" style="">
                                                </div>
                                                <div id="second_place_container" style="{{ $contest->possible_winners_count > 1 ? 'display: block' : '' }}">
                                                    <label>2nd Place</label>
                                                    <input type="number" min="0" max="100" class="with-border" value="{{ $contest->possible_winners_count > 1 ? $contest->second_place_prize : '' }}"
                                                        name="second_place" placeholder="%">
                                                </div>
                                                <div id="third_place_container" style="{{ $contest->possible_winners_count > 2 ? 'display: block' : '' }}">
                                                    <label>3rd Place</label>
                                                    <input type="number" min="0" max="100" class="with-border" value="{{ $contest->possible_winners_count > 2 ? $contest->third_place_prize : '' }}"
                                                        name="third_place" placeholder="%">
                                                </div>
                                                <div class="pos-warning"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 d-none">
                                <div class="submit-field">
                                    <h5>Contest Add-Ons</h5>
                                    <div class="row add-on-list">
                                        @foreach ($addons as $addon)
                                            <div class="col-sm-6">
                                                <div class="add-on-each">
                                                    <div class="row">
                                                        <div class="col-2 col-sm-2">
                                                            <div class="switch-container m-0">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="addon[]"
                                                                        class="contest-addon ad"
                                                                        data-amount="{{ $addon->amount }}"
                                                                        data-id="{{ $addon->id }}" value="yes">
                                                                    <span class="switch-button"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-7">
                                                            <div class="add-on-title">
                                                                {{ $addon->title }}
                                                            </div>
                                                        </div>
                                                        <div class="col-3 col-sm-3 pr-0 pr-sm-3 text-right">
                                                            <div class="add-on-price">
                                                                @if ($addon->amount)
                                                                    @if(auth()->user()->is_nigeria)
                                                                        {{-- {{ $dollar_rate }} --}}
                                                                        @php
                                                                            $converted_amount = $addon->amount * $dollar_rate;
                                                                        @endphp
                                                                        ₦{{ number_format($converted_amount) }}
                                                                    @else
                                                                        ${{ number_format($addon->amount) }}
                                                                    @endif

                                                                @else
                                                                    Free
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-10 offset-2 col-sm-10 offset-sm-2">
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
                                <p>You selected the Non-disclosure Agreement add on, do you want to use our <a
                                        href="#">Non-Disclosure Agreement</a> or write your own in the box below.</p>
                                <textarea name="nda" id="" class="with-border" rows="5"
                                    placeholder="Write Non-Disclosure Agreement here"></textarea>
                                <div class="container">
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Budget ({{ auth()->user()->is_nigeria == true ? '₦' : '$' }})</h5>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            @if(auth()->user()->is_nigeria == true)
                                                <input type="number" class="budget budget-input" placeholder="0,000"
                                                    name="budget" value="{{ $contest->budget }}" disabled>
                                            @else
                                            <input type="number" class="budget budget-input" placeholder="0,000"
                                                    name="budget" value="{{$contest->budget}}" disabled>
                                            @endif

                                            {{-- <span style="color: #666; font-size: 12px;">The system won't process amount less
                                                than the estimated budget
                                            </span>
                                            <br>
                                            <span style="color: green; clear:both; font-size: 12px;">You can increase your
                                                budget later to attract more designers.
                                            </span>
                                            <br>
                                            <span style="clear:both; font-size: 12px;" class="text-danger">
                                                Additional charge applies for duration less than 7 days
                                            </span> --}}
                                            <input type="hidden" class="min_budget" name="minimum_budget">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="submit-field">
                                    <h5>Duration (Days)</h5>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <input type="number" class="" value="7" name="duration" min="3" max="7" id="duration">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-5">
                                <div class="submit-field">
                                    <h5>Tags <span>(optional)</span> <i class="help-icon tippy" data-tippy-placement="right"
                                            title="Maximum of 10 tags"></i></h5>
                                    <div class="keywords-container">
                                        <div class="keyword-input-container">
                                            <input type="text" class="keyword-input with-border" value="" name="tags"
                                                placeholder="e.g. Contest title, responsibilites" />
                                        </div>
                                        <div class="keywords-list">
                                            <!-- keywords go here -->
                                            {{-- @foreach($contest->tags as $tag)
                                                <span class="keyword"><span class="keyword-remove"></span><span class="keyword-text">{{ $tag->title }}</span></span>
                                            @endforeach --}}
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-sm-3 sticky-budgets d-none d-sm-block budget-card">
                <div class="card">
                    <div class="d-flex align-items-center flex-column card-body">
                        <h6>Budget ($)</h6>
                        <h1 class="budget-text">-</h1>
                    </div>
                </div>
            </div> --}}

            <div class="col-xl-12 mb-5">
                <a href="javascript:void(0);" class="button ripple-effect uplNext big margin-top-30"
                    id="submit-contest-form"><i class="icon-feather-plus"></i> Create Contest</a>
                <div class="upload-notice"></div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
        const budget_input_text = $('.budget-text')
        const duration_input = $('#duration')
        const contest_addon = $('input.contest-addon[type=checkbox]')
        const nda = $('textarea[name=nda]')

        const first_place_container = $('#first_place_container')
        const second_place_container = $('#second_place_container')
        const third_place_container = $('#third_place_container')

        const first_place_input = $('input[name=first_place]')
        const second_place_input = $('input[name=second_place]')
        const third_place_input = $('input[name=third_place]')

        const is_nigeria = `{{ auth()->user()->is_nigeria ? true : false }}`
        const dollar_rate =   `{{ $dollar_rate }}`
        var real_budget_value
        console.log(dollar_rate)

        let title = ''
        let category = ''
        let description = ''
        let designer_level = ''
        let possible_winners = 1
        let budget = 0
        let duration = 0
        let tags
        let addons
        let duration_changed = false

        first_place_input.on('keyup', () => {
            if (first_place_input.val() > 100) {
                first_place_input.val(100)
            } else if (first_place_input.val() < 1) {
                first_place_input.val(1)
            }
            // Check if possible winners is 2
            if (possible_winners_select.val() == 2) {
                if (first_place_input.val() >= 100) {
                    first_place_input.val(99)
                }
                // Set second place winner to difference from 100
                second_place_input.val(100 - first_place_input.val())
            } else if (possible_winners_select.val() == 3) {
                // if (second_place_input.val() >= 100) {
                //     second_place_input.val(99)
                // }
                // Set third place winner to difference from 100
                if (second_place_input.val() != '') {
                    let new_value = (100 - second_place_input.val() - first_place_input.val() > 0) ? 100 -
                        second_place_input.val() - first_place_input.val() : 1
                    third_place_input.val(new_value)
                }
            }
        })

        second_place_input.on('keyup', () => {
            if (second_place_input.val() > 100) {
                second_place_input.val(100)
            } else if (second_place_input.val() < 1) {
                second_place_input.val(1)
            }

            // Check if possible winners is 2
            if (possible_winners_select.val() == 3) {
                // if (second_place_input.val() >= 100) {
                //     second_place_input.val(99)
                // }
                // Set third place winner to difference from 100
                if (first_place_input.val() != '') {
                    let new_value = (100 - second_place_input.val() - first_place_input.val() > 0) ? 100 -
                        second_place_input.val() - first_place_input.val() : 1
                    third_place_input.val(new_value)
                }
            }
        })

        third_place_input.on('keyup', () => {
            if (third_place_input.val() > 100) {
                third_place_input.val(100)
            } else if (third_place_input.val() < 1) {
                third_place_input.val(1)
            }
        })

        budget_input.on('keyup', () => {
            budget_input_text.text(comma(budget_input.val()))
        })

        category_select.on('change', () => {
            refreshBudget()
        })

        duration_input.on('change', () => {
            console.log('duration changed point')
            if (duration_input.val() < 7 && duration_changed == false) {
                duration_changed = true;
                refreshBudget()
            }else{
                duration_changed = false
                refreshBudget()
            }
            // refreshBudget()

            // if(duration_input.val() > 6 && duration_changed == true){
            //     console.log('greater than 7')
            //     // duration_changed == false;

            // }
        })

        contest_addon.on('change', (e) => {
            let addon_id = $(e.target).data('id')

            refreshBudget()

            // budget_input.val(budget)
            // budget_input_text.text(comma(budget))

            if (addon_id == 4) {
                if ($(e.target).is(':checked')) {
                    nda_form.slideDown();
                } else {
                    nda_form.slideUp();
                }
            }
        })

        function refreshBudget() {
            budget = 0;

            if (category_select.val() != '') {
                let selected_category = category_select.find('option:selected')
                let base_amount = selected_category.data('baseamount')
                budget += base_amount
            }

            $.each(contest_addon, (key, val) => {
                let addon_amount = $(val).data('amount')

                if ($(val).is(':checked')) {
                    budget += addon_amount
                    console.log(val, "is checked");

                }
            })

            if (duration_input.val() < 7 && duration_changed) {
                budget += 5
                console.log(duration_changed, 'addition')
            }

            if (duration_input.val() > 6 && duration_changed){
                budget -= 5
                duration_changed = false
                console.log(duration_changed, 'substraction')
            }



            if(is_nigeria == 1){
                var conversion_value = budget * dollar_rate;
                real_budget_value = parseFloat(conversion_value.toFixed(2));

            }else{
                real_budget_value = budget;
            }
            budget_input.val(real_budget_value)
            budget_input_text.text(comma(real_budget_value))
        }

        possible_winners_select.on('change', e => {
            first_place_input.attr({
                readonly: true
            })
            second_place_input.attr({
                readonly: true
            })
            third_place_input.attr({
                readonly: true
            })

            switch ($(e.target).val()) {
                case '3':
                    first_place_container.slideDown()
                    second_place_container.slideDown()
                    third_place_container.slideDown()
                    first_place_input.removeAttr('readonly')
                    second_place_input.removeAttr('readonly')
                    break;
                case '2':
                    first_place_container.slideDown()
                    second_place_container.slideDown()
                    third_place_container.slideUp()
                    first_place_input.removeAttr('readonly')
                    break;
                default:
                    first_place_container.slideUp()
                    second_place_container.slideUp()
                    third_place_container.slideUp()
                    break;
            }
        })

        Dropzone.autoDiscover = false;
        const contestImagesDropzone = new Dropzone("#contest-images-form", {
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 5,
            maxFiles: 5000,
            dictRemoveFileConfirmation: 'Are you sure you want to remove this file',
            dictDefaultMessage: '<h1 class="icon-feather-upload-cloud" style="color: orange;"></h1><p>Drop files here to upload!</p>'
        })

        // console.log(contestImagesDropzone)

        contestImagesDropzone.on('addedfile', (file) => {
            file.previewElement.addEventListener('click', () => {
                preview_image_modal.find('img').attr({
                    src: file.dataURL
                })
                preview_image_modal.modal('show')
            })
        })

        contestImagesDropzone.on('totaluploadprogress', (progress) => {
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

        contestImagesDropzone.on('queuecomplete', () => {
            console.log("All files have been uploaded successfully");
            // contestImagesDropzone.reset()
            contestImagesDropzone.removeAllFiles()
            goToListingStep(4)
            create_listing_form_3_view.hide()
            create_listing_form_4_view.fadeIn()
        })

        contestImagesDropzone.on('error', (file, errorMessage, xhrError) => {
            console.log("Error occurred here: ", file, errorMessage, xhrError);
        })

        $('#add-listing-images-button').on('click', () => {
            // $('#upload-progress').attr({
            //     'aria-valuenow': 0
            // }).css({
            //     width: `0%`
            // }).removeClass('bg-warning').addClass('bg-success')
            contestImagesDropzone.processQueue()
        })

        submit_contest_form_btn.on('click', () => {
            let selected_category = category_select.find('option:selected')
            let base_amount = selected_category.data('baseamount')

            if (budget_input.val() < base_amount) {
                Snackbar.show({
                    text: `Your busget is lower than the minimum for the selected category. Mnimum: $${comma(base_amount)}`,
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                loading_container.hide()
                return
            }

            if (possible_winners_select.val() == 2 && parseFloat(first_place_input.val()) + parseFloat(
                    second_place_input.val()) > 100) {
                Snackbar.show({
                    text: `Please check the total prize money shared between the ${possible_winners_select.val()} winners.`,
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                loading_container.hide()
                return
            } else if (possible_winners_select.val() == 3 && parseFloat(first_place_input.val()) + parseFloat(
                    second_place_input.val()) +
                parseFloat(third_place_input.val()) > 100) {
                Snackbar.show({
                    text: `Please check the total prize money shared between the ${possible_winners_select.val()} winners.`,
                    pos: 'top-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 5000,
                    textColor: '#fff',
                    backgroundColor: '#721c24'
                });
                loading_container.hide()
                return
            }

            console.log(contestImagesDropzone.getQueuedFiles())
            // if (contestImagesDropzone.getQueuedFiles() < 1) {
            //     Snackbar.show({
            //         text: 'Please add at least one file and fill all fields.',
            //         pos: 'top-center',
            //         showAction: false,
            //         actionText: "Dismiss",
            //         duration: 5000,
            //         textColor: '#fff',
            //         backgroundColor: '#721c24'
            //     });
            //     loading_container.hide()
            //     return
            // }

            loading_container.show();
            tags = [];
            addons = [];
            var actual_budget;
            var currency;
            var first_val = parseFloat(budget_input.val().trim()) + parseFloat((duration_input.val() < 7 ? 5 : 0))
            if(is_nigeria == 1){
                // var conversion = dollar_rate * first_val;
                actual_budget = parseFloat(first_val.toFixed(2));
                currency = 'naira';
            }else{
                // actual_budget = parseFloat(budget_input.val().trim()) + parseFloat((duration_input.val() < 7 ? 5 : 0))
                actual_budget = parseFloat(first_val.toFixed(2));
                currency = 'dollar'
            }

            let payload = {
                title: title_input.val().trim(),
                category: category_select.val(),
                description: description_textarea.val().trim(),
                designer_level: designer_level_select.val(),
                possible_winners: possible_winners_select.val(),
                first_place_prize: first_place_input.val(),
                second_place_prize: second_place_input.val(),
                third_place_prize: third_place_input.val(),
                budget: actual_budget,
                currency: currency,
                duration: duration_input.val().trim(),
                nda: $('input.contest-addon[type=checkbox][data-id=4]').is(':checked') ? nda.val().trim() : '',
            }

            // get selected addons
            $.each(contest_addon, (key, val) => {
                if ($(val).is(':checked')) {
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
            payload = {
                ...payload,
                _token,
                tags,
                addons
            }
            console.log(payload)
            fetch(`{{ route('contests.edit-contest', $contest->id) }}`, {
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
                        $("#contest-images-form").find('input[name=contest_id]').val(responseJson
                            .contest_id)
                        // Submit media for contest
                        await contestImagesDropzone.processQueue()
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#28a745'
                        });
                        setTimeout(() => {
                            // window.location =
                            //     `{{ url('contests/payment') }}/${responseJson.contest_id}`;
                            window.location =
                                `{{ url('contests') }}/${responseJson.contest_slug}`;
                        }, 5000)
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
