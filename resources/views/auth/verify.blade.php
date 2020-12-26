@extends('layouts.app')

@section('page_content')
<div class="container">
    <div class="row justify-content-center account-verify-container">
        <div class="col-md-8">

            <h4 class="text-center">
                Welcome to {{ config('app.name') }}
            </h4>

			<div class="col-xl-4 col-md-4 offset-md-4">
                <div class="icon-box mt-0 mb-5">
                    <div class="icon-box-circle mb-5">
                        <div class="icon-box-circle-inner">
                            <i class="icon-material-outline-email"></i>
                            <div class="icon-box-check">
                                <i class="icon-material-outline-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <h3 class="text-center">
                Verify your email address to continue
            </h3> --}}

            <div class="text-center">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <div>
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    <br>
                    {{ __('If you did not receive the email') }},
                    <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
