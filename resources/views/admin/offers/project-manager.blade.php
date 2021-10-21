@extends('admin.layouts.app')

@section('page_styles')
    <style type="text/css">
        .contests-banner{
            background-image: url("{{ asset('images/banners/1.png') }}");
        }
        .contests-banner-inner {
            padding-top: 50px;
            padding-bottom: 30px;
            background: none;
        }
        .contest-user-card-avatar {
            height: 70px;
            max-width: 70px;
            margin-right: 10px;
            object-fit: contain;
        }
        .each-contest-user-count {
            margin-right: 30px;
            text-align: center;
        }

        .each-contest-user-count h6 {
            font-size: 10px;
            text-transform: uppercase;
        }
        @media (min-width: 1367px) {
            .container {
                max-width: 1210px;
            }
        }
    </style>
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xl-12 content-left-offset">

            <h3 class="page-title text-capitalize">
               All Project Manager Offers
            </h3>

            <div class="notify-box margin-top-15 mb-5">
                {{-- <div class="switch-container">
                    <label class="switch"><input type="checkbox"><span class="switch-button"></span><span
                            class="switch-text">Turn on email alerts for this search</span></label>
                </div> --}}

                <div class="sort-by">
                    <span>Sort by:</span>
                    <select class="selectpicker hide-tick" id='sort'>
                        <option value="" {{ $status == '' || $status == null ? 'selected' : '' }}>All</option>
                        <option value="on hold" {{ $status == 'on hold' ? 'selected' : '' }}>On Hold</option>
                        <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="closed" {{ $status == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
            </div>

            <div class="listings-container compact-list-layout margin-top-10">
                @forelse ($offers as $offer)
                    {{-- @php $offer = json_decode(json_encode($offer)); @endphp --}}
                    @include("offers.project-manager.project-manager-offer-row", ["offer" => $offer])

                @empty
                    <div class="alert alert-info">
                        <small>
                            There are no {{ $status }} offers available at the moment.
                        </small>
                    </div>
                @endforelse
            </div>

            {{-- <div class="mt-3">
                {{ $offers->links() }}
            </div> --}}

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

        const sort = $("#sort")
        const page_url = `{{ route('admin.offers.project-manager') }}`

        sort.on("change", function(e) {
            console.log('changed')
            let status = sort.val()
            let query = "?status=" + status
            let new_url
            if(status == ''){
                new_url = `${page_url}`
            }else{
                new_url = `${page_url}${query}`
            }



            console.log(new_url)

            window.location.href = new_url
        })
    </script>
@endsection
