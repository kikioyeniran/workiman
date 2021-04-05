@extends('layouts.app')

@section('page_styles')
@endsection

@section('page_content')
    <div class="single-page-header create-offer-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="headline">
                        <h1>New Offer</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('offers.new') }}" method="post" name="job_form" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="offer_type" value="freelancer">
            <div class="row">
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                        <div class="content with-padding padding-bottom-10">
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="submit-field">
                                        <h5>Offer Title</h5>
                                        <input type="text" class="with-border tippy" value="" placeholder="Offer Title" name="title" required>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Offer Category</h5>
                                        <select class="with-border category-input" name="category" data-placeholder="Select Category" required>
                                            <option value="">-</option>
                                            @foreach ($categories as $category)
                                                <optgroup label="{{ $category->title }}">
                                                    @foreach ($category->Offer_sub_categories as $sub_category)
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
                                        <h5>Offer Description</h5>
                                        <textarea cols="30" rows="5" name="description" class="with-border tippy" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet blanditiis nemo nobis placeat. Atque, doloribus esse eveniet fuga fugiat illum ipsa labore magni molestiae mollitia nemo obcaecati totam unde ut." required></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>Price(NGN)</h5>
                                        <input type="number" class="budget budget-input" placeholder="15000" name="price" required>
                                    </div>
                                </div>

                                <div class="col-xl-6 timeline-container">
                                <div class="submit-field">
                                    <h5>Timeline</h5>
                                    <select class="with-border tippy" name="timeline" data-placeholder="No of designers" required>
                                        <option value="">-</option>
                                        @for ($i = 1; $i <= 30; $i++)
                                            <option value="{{ $i }}">{{ $i }}
                                                day{{ $i == 1 ? '' : 's' }}</option>
                                        @endfor
                                    </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 mb-5 text-center">
                    <button type="submit" class="button ripple-effect uplNext big margin-top-30"><i class="icon-feather-plus"></i> Submit Offer</button>
                    <div class="upload-notice"></div>
                </div>
            </div>
        </form>
    </div>
@endsection

