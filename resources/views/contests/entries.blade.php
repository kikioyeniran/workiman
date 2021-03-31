@extends('account.layouts.app')

@section('page_styles')
    <style>
    </style>
@endsection

@section('page_content')
    <div class="dashboard-headline mb-3">
        <h3>
            Contests you have submitted to.
        </h3>
        <span class="d-none">We are glad to see you again!</span>
    </div>

    <div class="row">
        @forelse ($contest_entries as $contest)
            <div class="col-sm-6">
                @include("contests.contest_row", ["contest" => $contest])
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <small>
                        You have not made any contest submissions yet.
                    </small>
                </div>
                <div class="text-center">
                    <a href="#" class="btn btn-custom-primary text-uppercase text-white px-5">
                        <small>
                            Click here to browse active contests
                        </small>
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@section('page_scripts')
<script>
    // $('#registerFreelancerModal').modal('show')
    $('select').select2();
    $(document).ready(function() {});

</script>
@endsection
