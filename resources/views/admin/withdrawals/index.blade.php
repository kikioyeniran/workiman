@extends('admin.layouts.app')

@section('page_title', "{$status} Withdrawals")

@section('page_styles')
    <style>
        .btn {
            font-size: 12px;
            padding: 7px 15px;
            border-radius: 5px;
            margin: 0 5px;
        }

        .text-success {
            color: green;
        }

        .text-danger {
            color: rgb(204, 78, 78);
        }

        .btn-success {
            background-color: green;
            color: white;
        }

        .btn-danger {
            background-color: rgb(204, 78, 78);
            color: white;
        }

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
                                <th>Reference</th>
                                <th>User</th>
                                <th>Amount</th>
                                <th class="d-none">FX Rate</th>
                                <th>Account</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($withdrawals as $withdrawal)
                                <tr>
                                    <td data-label="Column 1">
                                        {{ $withdrawal->reference }}
                                    </td>
                                    <td data-label="Column 1">
                                        {{ $withdrawal->user->full_name }}
                                    </td>
                                    <td>
                                        {{ ($withdrawal->currency == 'ngn' ? '₦' : '$') . number_format($withdrawal->amount) }}
                                    </td>
                                    <td class="d-none">
                                        {{ ($withdrawal->currency == 'ngn' ? '₦' : '$') . number_format($withdrawal->fx_rate) }}
                                    </td>
                                    <td>
                                        <div style="font-size: x-small;text-transform: uppercase">
                                            {{ $withdrawal->bank_name }}
                                        </div>
                                        @if ($withdrawal->currency == 'ngn')
                                            <small>
                                                {{ $withdrawal->account_number }}
                                            </small>
                                            <br>
                                            <small>
                                                {{ $withdrawal->account_name }}
                                            </small>
                                        @else
                                            <small>
                                                {{ $withdrawal->account_name }}
                                            </small>
                                        @endif
                                    </td>
                                    <td data-label="Column 3">
                                        @if ($withdrawal->status == 'pending')
                                            <a href="{{ route('admin.withdrawals.approve-reject', ['withdrawal' => $withdrawal, 'status' => 'approved']) }}"
                                                class="btn btn-success">
                                                Mark as Approved
                                                <i class="icon-feather-check"></i>
                                            </a>
                                            <a href="{{ route('admin.withdrawals.approve-reject', ['withdrawal' => $withdrawal, 'status' => 'rejected']) }}"
                                                class="btn btn-danger">
                                                Mark as Rejected
                                                <i class=" icon-line-awesome-close"></i>
                                            </a>
                                        @elseif ($withdrawal->status == 'rejected')
                                            <span class="text-danger">
                                                Rejected
                                            </span>
                                        @else
                                            <span class="text-success">
                                                Approved
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
