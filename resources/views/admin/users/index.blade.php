@extends('admin.layouts.app')

@section('page_title')
    @switch($user_category)
        @case('freelancers')
            Freelancers
        @break
        @case('project-managers')
            Project Managers
        @break
        @default
            All Users
    @endswitch
@endsection

@section('page_styles')
<style>

</style>
@endsection

@section('page_content')
<div class="row">

    <!-- Dashboard Box -->
    <div class="col-xl-12">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3><i class="icon-material-outline-assignment"></i> @yield('page_title')</h3>
                <button href="#add-category-popup"
                    class="mark-as-read ripple-effect-dark full-width popup-with-zoom-anim" title="Add new category"
                    data-tippy-placement="left">
                    <i class="icon-feather-plus"></i>
                </button>
            </div>

            <div class="content p-5" style="padding: 20px;">
                <table class="basic-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Account Type</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($users as $key => $user)
                            @php
                                $count++;
                            @endphp
                            <tr>
                                <td data-label="Column 1">{{$loop->iteration}}</td>
                                <td data-label="Column 1">
                                    {{ $user->full_name }}
                                </td>
                                <td data-label="Column 1">
                                    {{ $user->email }}
                                </td>
                                <td data-label="Column 1">
                                    {{ $user->phone }}
                                </td>
                                <td data-label="Column 2">
                                    @if ($user->freelancer)
                                        Freelancer
                                    @else
                                        Project Manager
                                    @endif
                                </td>
                                <td>{{\Carbon\Carbon::parse($user->created_at)->toFormattedDateString()}}</td>
                                <td data-label="Column 3">
                                    {{-- {{ something }} --}}
                                    @if($user->disabled == true)
                                        <a href="" class="button ripple-effect big margin-top-30" style="background-color: red">
                                            Disabled
                                        </a>
                                        <a href="{{ route('admin.users.restore', $user->id) }}" class="button ripple-effect big margin-top-30" style="background-color: green">
                                            Restore Account
                                        </a>
                                    @else
                                        <a href="{{ route('admin.users.disable', $user->id) }}" class="button ripple-effect big margin-top-30">
                                            Disable
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    Full Name
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->full_name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
            </div>
        </div>
    </div>

</div>
@endsection

@section('page_scripts')
<script>
    $(document).ready(() => {
        $('table').DataTable({
            order: [
                [0, 'asc']
            ]
        })
    })

</script>
@endsection
