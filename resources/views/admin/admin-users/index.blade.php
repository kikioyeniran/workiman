@extends('admin.layouts.app')

@section('page_title')
    Admin Users
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
                            <th>Username</th>
                            <th>Account Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td data-label="Column 1">
                                    {{ $user->username }}
                                </td>
                                <td data-label="Column 2">
                                    Admin
                                </td>
                                <td data-label="Column 3">
                                    <a href="{{ route('admin.users.disable', $user->id) }}" class="button ripple-effect big margin-top-30">
                                        Disable
                                    </a>
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

<div id="add-category-popup" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a>Create Admin User</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Form -->
                <form method="POST" action="{{ route('admin.admin-users.store') }}" enctype="multipart/form-data">
                    @csrf

                    <label for="" style="color: black">Email</label>
                    <input class=" with-border default margin-bottom-20" name="email" title="Priority" placeholder="" required />

                    <label for="" style="color: black">First Name</label>
                    <input class=" with-border default margin-bottom-20" name="first_name" title="Priority" placeholder="" required />

                    <label for="" style="color: black">Last Name</label>
                    <input class=" with-border default margin-bottom-20" name="last_name" title="Priority" placeholder="" required />

                    <label for="" style="color: black">Username</label>
                    <input class=" with-border default margin-bottom-20" name="username" title="Priority" placeholder="" required />

                    {{-- <label for="" style="color: black">Image</label>
                    <input type="file" class=" with-border default margin-bottom-20" name="picture" title="Priority" required accept="image/*" /> --}}

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit">Save <i class="icon-material-outline-arrow-right-alt"></i></button>

                </form>
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
                [0, 'desc']
            ]
        })
    })

</script>
@endsection
