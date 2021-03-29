@extends('layouts.app')

@section('page_styles')
    <style>
        .offers-headers {
            /* display: block; */
            flex: 1;
        }
        .offers-header-each {
            background-color: white;
            padding: 15px 30px;
            color: black;
            text-transform: uppercase;
            border-radius: 3px;
            border-top: 2px solid #e09426;
            box-shadow: 3px 3px 10px 3px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
            margin-left: 10px;
        }
        .offers-header-each:hover {
            color: black;
            box-shadow: 3px 5px 20px 3px rgba(0, 0, 0, 0.15);
        }
        .no-offer-message {
            flex: 1;
        }

        .contests-banner-inner {
            padding-top: 50px;
            padding-bottom: 30px;
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
    </style>
@endsection

@section('page_content')
    <div class="contests-banner mb-4">
        <div class="contests-banner-inner">
            <div class="container">
                <div class="contest-user-card d-flex align-items-center flex-wrap mb-4">
                    <div class="contest-user-card-avatar">
                        <img src="{{ asset(is_null($user->avatar) ? ("images/user-avatar-placeholder.png") : ("storage/avatars/{$user->avatar}")) }}" alt="" class="img-thumbnail">
                    </div>
                    <h3 class="text-white mb-0">
                        {{ trim($user->full_name) != '' ? $user->full_name : $user->email }}
                        @if (!$user->freelancer)
                            <div style="font-size: small;color: #ddd;">Project Manager</div>
                        @endif
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="boxed-list-headline mb-3">
            <h3 class="mb-0">
                <i class=" icon-material-outline-announcement"></i>
                Offers Assigned to {{ $user->display_name }}
            </h3>
        </div>

        <div class="listings-container compact-list-layout margin-top-10">
            @forelse ($offers as $offer)
                @include("offers.project-manager.project-manager-offer-row", ["offer" => $offer])
            @empty
                <div class="alert alert-info">
                    <small>
                        There are no offers available at the moment.
                    </small>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('page_scripts')
    <script type="text/javascript">
        const each_active_offer_head = $('.each-active-offer-head')
        // const each_active_offer_title = $('.each-active-offer-head-title')
        const each_active_offer_body = $('.each-active-offer-body')

        each_active_offer_head.on('click', (e) => {
            let data_ind = $(e.target).data('ind')

            if($('.offer-body-'+data_ind).css('display') == 'none') {
                $('.each-active-offer-body').hide()

                $('.offer-body-'+data_ind).fadeIn()
            } else {
                $('.each-active-offer-body').hide()
            }
            // $('.offer-body-'+data_ind).css('display', 'block')
        })
    </script>
@endsection
