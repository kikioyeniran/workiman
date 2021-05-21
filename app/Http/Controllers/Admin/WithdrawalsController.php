<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalsController extends Controller
{
    public function index($status = 'pending')
    {
        $withdrawals = Withdrawal::whereNotNull('id');

        $withdrawals = $withdrawals->where('status', $status);

        $withdrawals = $withdrawals->get();

        return view("admin.withdrawals.index", compact('withdrawals', 'status'));
    }

    public function approveReject(Withdrawal $withdrawal, $status)
    {
        $withdrawal->status = $status;
        $withdrawal->save();

        return redirect()->route('admin.withdrawals', ['status' => 'pending'])->with('success', 'Withdrawal status changed successfully.');
    }
}