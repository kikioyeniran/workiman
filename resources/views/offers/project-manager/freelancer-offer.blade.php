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

<div class="single-page-header margin-bottom-20" data-background-image="{{ asset('_home/images/single-job.jpg') }}">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-image">
                            <a href="single-company-profile.html">
                                <img src="{{ asset(is_null($offer->user->avatar) ? ("images/user-avatar-placeholder.png") : ("storage/avatars/{$offer->user->avatar}")) }}" alt="">
                            </a>
                        </div>
						<div class="header-details">
							<h3>
                                {{ $offer->title }}
                            </h3>
							<h5>
                                {{ $offer->sub_category->offer_category->title }}
                            </h5>
							<ul>
                                <li>
                                    <a>
                                        <i class="icon-material-outline-mouse text-custom-primary"></i>
                                        @if($offer->minimum_designer_level == 0)
                                            Any designer can apply
                                        @else
                                            Only designers with minimum of {{ $offer->minimum_designer_level }} can apply
                                        @endif
                                    </a>
                                </li>
								{{-- <li><div class="star-rating" data-rating="4.9"></div></li>
								<li><img class="flag" src="images/flags/gb.html" alt=""> United Kingdom</li>
								<li><div class="verified-badge-with-title">Verified</div></li> --}}
							</ul>
						</div>
					</div>
					<div class="right-side">
						<div class="salary-box">
							<div class="salary-type">
                                Price
                            </div>
							<div class="salary-amount">
                                ${{ number_format($offer->price) }}
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


    <div class="container">
        <input type="hidden" name="offer_type" value="freelancer">
        @include('layouts.section-header', ['header' => "Send your offer to {$offer->user->display_name}"])
        <div class="row">
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <div class="content with-padding padding-bottom-10">


                        <div class="row">
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 mb-5 text-center">
                <a class="button ripple-effect uplNext big margin-top-30" id="submit-offer-form"><i
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
