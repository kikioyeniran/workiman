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

    </style>
@endsection

@section('page_content')
    <div class="single-page-header create-offer-header margin-bottom-40">
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
        {{-- <form action="{{ route('offers.new') }}" method="post" name="job_form" enctype="multipart/form-data">
            @csrf --}}

        <h1 class=" margin-bottom-20">
            <small>
                New Offer
            </small>
        </h1>

        <input type="hidden" name="offer_type" value="freelancer">
        <div class="row">
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="content with-padding padding-bottom-10">
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="submit-field">
                                    <h5>Offer Title</h5>
                                    <input type="text" class="with-border tippy" value="" placeholder="Offer Title"
                                        name="title" required>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Offer Category</h5>
                                    <select class="with-border category-input" name="category"
                                        data-placeholder="Select Category" required>
                                        <option value="">-</option>
                                        @foreach ($categories as $category)
                                            <optgroup label="{{ $category->title }}">
                                                @foreach ($category->Offer_sub_categories as $sub_category)
                                                    <option value="{{ $sub_category->id }}"
                                                        data-baseamount="{{ $sub_category->base_amount }}">
                                                        {{ $sub_category->title }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Skills Required</h5>

                                    <div class="keywords-container">
                                        <div class="keyword-input-container">
                                            <input type="text" class="keyword-input with-border" placeholder="Corel Draw" />
                                            <button class="keyword-input-button ripple-effect"><i
                                                    class="icon-material-outline-add"></i></button>
                                        </div>
                                        {{-- @if ($user->freelancer_profile) --}}
                                        <div class="skills keywords-list" id="skills-keywords">
                                            {{-- @foreach (explode(',', $user->freelancer_profile->skills) as $skill)
                                                        <span class="keyword"><span class="keyword-remove"></span><span class="keyword-text">{{ $skill }}</span></span>
                                                    @endforeach --}}
                                        </div>
                                        {{-- @endif --}}
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Expert Level</h5>
                                    <select class="with-border tippy" name="designer_level"
                                        data-placeholder="No of designers">
                                        <option value="">-</option>
                                        <option value="0">Anybody can apply</option>
                                        <option value="3">Minimum of 3 stars</option>
                                        <option value="5">5 stars</option>
                                    </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Budget($)</h5>
                                    <input type="number" class="budget budget-input" placeholder="15000" name="budget">
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Offer Description</h5>
                                    <textarea cols="30" rows="5" name="description" class="with-border tippy"
                                        placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet blanditiis nemo nobis placeat. Atque, doloribus esse eveniet fuga fugiat illum ipsa labore magni molestiae mollitia nemo obcaecati totam unde ut."
                                        required></textarea>
                                </div>
                            </div>

                            <div class="col-xl-12 mb-4">
                                <form action="{{ route('offer.images') }}" method="POST" id="contest-images-form"
                                    class="dropzone" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="offer_id" id="offer_id" value="" required />
                                </form>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-xl-6 delivery-mode-container">
                                <div class="submit-field">
                                    <h5>Delivery Mode</h5>
                                    <select class="with-border tippy" name="delivery_mode"
                                        data-placeholder="No of designers">
                                        <option value="">-</option>
                                        <option value="once">One time</option>
                                        <option value="continuous">Continuous Contract</option>
                                    </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-xl-6 timeline-container">
                                <div class="submit-field">
                                    <h5>Timeline</h5>
                                    <select class="with-border tippy" name="timeline" data-placeholder="No of designers">
                                        <option value="">-</option>
                                        @for ($i = 1; $i <= 30; $i++)
                                            <option value="{{ $i }}">{{ $i }}
                                                day{{ $i == 1 ? '' : 's' }}</option>
                                        @endfor
                                    </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-xl-6 offer-type-container">
                                <div class="submit-field">
                                    <h5>Offer Type</h5>
                                    <select class="with-border tippy" name="offer_type" data-placeholder="No of designers">
                                        <option value="">-</option>
                                        <option value="public">Public Offer</option>
                                        <option value="private">Private Offer</option>
                                    </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-xl-6 offer-user-container">
                                <div class="submit-field">
                                    <h5>Select User</h5>
                                    <select class="with-border tippy" name="offer_user" data-placeholder="No of designers">
                                        <option value="" data-user="">-</option>
                                        <option value="public" data-user="all">All Freelancers</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" data-user="freelancer">
                                                {{ '@' }}{{ $user->username }}</option>
                                        @endforeach
                                    </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Add-Ons</h5>
                                    <div class="row add-on-list">
                                        @foreach ($addons as $addon)
                                            <div class="col-sm-6">
                                                <div class="add-on-each">
                                                    <div class="row">
                                                        <div class="col-2 col-sm-1">
                                                            <div class="switch-container m-0">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="addon[]"
                                                                        class="offer-addon ad"
                                                                        data-amount="{{ $addon->amount }}"
                                                                        data-id="{{ $addon->id }}" value="yes">
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
                                <p>You selected the Non-disclosure Agreement add on, do you want to use our <a
                                        href="#">Non-Disclosure Agreement</a> or write your own in the box below.</p>
                                <textarea name="nda" id="" class="with-border" rows="5"
                                    placeholder="Write Non-Disclosure Agreement here"></textarea>
                                <div class="container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 mb-5">
                <a class="button ripple-effect uplNext big margin-top-30 text-white" id="submit-offer-form"><i
                        class="icon-feather-plus"></i> Submit Offer</a>
                <div class="upload-notice"></div>
            </div>
        </div>
        {{-- </form> --}}
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('js/contest-dropzone.js') }}"></script>

    <script>
        const offer_type_container = $("div.offer-type-container")
        const offer_user_container = $("div.offer-user-container")

        const submit_offer_form_btn = $('#submit-offer-form');
        const skills_keywords_list = $('.skills.keywords-list')
        const nda_form = $('#nda-form')

        const title_input = $('input[name=title]')
        const category_select = $('select[name=category]')
        const designer_level_select = $('select[name=designer_level]')
        const budget_input = $('input[name=budget]')
        const description_textarea = $('textarea[name=description]')
        const delivery_mode_select = $('select[name=delivery_mode]')
        const timeline_select = $('select[name=timeline]')
        const offer_type_select = $('select[name=offer_type]')
        const offer_user_select = $('select[name=offer_user]')
        const nda_textarea = $('textarea[name=nda]')
        const offer_addon = $('input.offer-addon[type=checkbox]')

        let title = ''
        let category = ''
        let designer_level = ''
        let budget = 0
        let description = ''
        let delivery_mode = ''
        let timeline = ''
        let offer_type = ''
        let offer_user = ''
        let nda = ''
        let addons
        let skills

        category_select.on('change', () => {
            refreshBudget()
        })

        offer_addon.on('change', (e) => {
            let addon_id = $(e.target).data('id')

            refreshBudget()

            budget_input.val(budget)

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

            $.each(offer_addon, (key, val) => {
                let addon_amount = $(val).data('amount')

                if ($(val).is(':checked')) {
                    budget += addon_amount
                    console.log(val, "is checked");

                }
            })

            budget_input.val(budget)
        }


        offer_type_select.on('change', (e) => {
            let selected_offer_type = $(e.target).val()

            if (selected_offer_type == 'public') {
                offer_user_select.val('public')
                offer_user_select.find('option[data-user="freelancer"]').hide()
                offer_user_select.find('option[data-user="all"]').show()
            } else if (selected_offer_type == 'private') {
                offer_user_select.val('')
                offer_user_select.find('option[data-user="all"]').hide()
                offer_user_select.find('option[data-user="freelancer"]').show()
            } else {
                offer_user_select.val('')
                offer_user_select.find('option[data-user="all"]').show()
                offer_user_select.find('option[data-user="freelancer"]').show()
            }
        })

        Dropzone.autoDiscover = false;
        const offerImagesDropzone = new Dropzone("#contest-images-form", {
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 5,
            maxFiles: 5,
            dictRemoveFileConfirmation: 'Are you sure you want to remove this file',
            dictDefaultMessage: '<h1 class="icon-feather-upload-cloud" style="color: orange;"></h1><p>Drop files here to upload!</p>'
        })

        // console.log(offerImagesDropzone)

        offerImagesDropzone.on('addedfile', (file) => {
            file.previewElement.addEventListener('click', () => {
                preview_image_modal.find('img').attr({
                    src: file.dataURL
                })
                preview_image_modal.modal('show')
            })
        })

        offerImagesDropzone.on('totaluploadprogress', (progress) => {
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

        offerImagesDropzone.on('queuecomplete', () => {
            console.log("All files have been uploaded successfully");
            // offerImagesDropzone.reset()
            offerImagesDropzone.removeAllFiles()
        })

        offerImagesDropzone.on('error', (file, errorMessage, xhrError) => {
            console.log("Error occurred here: ", file, errorMessage, xhrError);
        })

        submit_offer_form_btn.on('click', () => {
            loading_container.show();
            skills = [];
            addons = [];

            let payload = {
                offer_type: 'project-manager',
                title: title_input.val().trim(),
                category: category_select.val(),
                designer_level: designer_level_select.val(),
                budget: budget_input.val().trim(),
                description: description_textarea.val().trim(),
                delivery_mode: delivery_mode_select.val(),
                timeline: timeline_select.val(),
                this_offer_type: offer_type_select.val(),
                offer_user: offer_user_select.val(),
                nda: $('input.offer-addon[type=checkbox][data-id=4]').is(':checked') ? nda_textarea.val()
                    .trim() : ''
            }

            // get selected addons
            $.each(offer_addon, (key, val) => {
                if ($(val).is(':checked')) {
                    addons.push($(val).data('id'))
                }
            })

            // Get skills from input
            let skills_keywords = skills_keywords_list.find('span.keyword-text')

            $.each(skills_keywords, (key, val) => {
                // push each tag to tag array
                let skills_text = val.innerText
                skills.push(skills_text)
            })

            // Add skills to payload
            // make request to save offer
            payload = {
                ...payload,
                _token,
                skills,
                addons
            }
            console.log("Payload is: ", payload);

            // return
            fetch(`{{ route('offers.new') }}`, {
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
                        $("#contest-images-form").find('input[name=offer_id]').val(responseJson.offer_id)
                        // Submit media for contest

                        // console.log(offerImagesDropzone.getQueuedFiles())
                        if (offerImagesDropzone.getQueuedFiles().length >= 1) {
                            await offerImagesDropzone.processQueue()
                        }

                        setTimeout(() => {
                            console.log("All Submitted");

                            // loading_container.hide()
                            window.location =
                                `{{ url('offers/payment/project-managers') }}/${responseJson.offer_id}`;
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
