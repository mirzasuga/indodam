<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-').'01');
        $endDate = $request->get('end_date', date('Y-m-t'));

        $transactionQuery = Transaction::with(['sender', 'receiver'])
            ->latest()
            ->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);

        if (!is_null(request('query'))) {
            $transactionQuery->where('id', request('query'));
        }

        if (!is_null(request('sender_id'))) {
            $transactionQuery->where('sender_id', request('sender_id'));
        }

        if (!is_null(request('type'))) {
            $transactionQuery->where('type', request('type'));
        }

        if (!is_null(request('receiver_id'))) {
            $transactionQuery->where('receiver_id', request('receiver_id'));
        }

        $transactions = $transactionQuery->paginate(50);

        $users = User::orderBy('name')->pluck('name', 'id')->prepend('INDODAM System', 0);

        return view('transactions.index', compact(
            'transactions',
            'users',
            'startDate',
            'endDate'
        ));
    }
}
