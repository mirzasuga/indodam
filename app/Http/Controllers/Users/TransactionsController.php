<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Transaction;
use App\TransactionType;
use App\User;
use Illuminate\Http\Request;
use DB;
use App\Wallet;

class TransactionsController extends Controller
{
    public function index(User $user)
    {
        $this->authorize('view', $user);
        $users = [];
        $receiver = null;

        $incomes = $user->incomes()->latest()->with('sender')->get();
        $outcomes = $user->outcomes()
            ->where('type', '!=', 'new_member_bonus')
            ->latest()
            ->with('receiver')
            ->get();

        $depositTypeList = TransactionType::getDepositTypeList();
        $withdrawTypeList = TransactionType::getWithdrawTypeList();

        if (request('action') == 'transfer') {
            $users = User::orderBy('username')->pluck('username', 'id');
            $receiver = User::where('username', request('receiver_username'))->first();
        }

        return view('users.transactions', compact(
            'user', 'incomes', 'outcomes',
            'depositTypeList', 'withdrawTypeList',
            'users', 'receiver'
        ));
    }

    public function deposit(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $depositData = $request->validate([
            'type'         => 'required|string',
            'amount'       => 'required|numeric',
            'description'  => 'required|string|max:255',
            'double_check' => 'required|accepted',
        ]);
        DB::beginTransaction();
            $user->depositWallet(
                $depositData['amount'],
                $depositData['type'],
                0,
                [
                    'sender_id'   => 0, // INDODAM System
                    'creator_id'  => auth()->id(),
                    'description' => $depositData['description'],
                    'notes'       => 'sent_by_system'
                ]
            );
            $walletUser = $user->wallet()->first();
            $walletUser->incrementDam($depositData['amount'])->save();

        DB::commit();
        flash(__('transaction.deposit_success'), 'success');

        return redirect()->route('profile.transactions.index', $user);
    }

    public function withdraw(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $withdrawData = $request->validate([
            'type'         => 'required|string',
            'amount'       => 'required|numeric|max:'.$user->wallet,
            'description'  => 'required|string|max:255',
            'double_check' => 'required|accepted',
        ], [
            'amount.max' => __('transaction.insufficient_wallet', ['amount' => $user->wallet]),
        ]);

        $user->withdrawWallet(
            $withdrawData['amount'],
            $withdrawData['type'],
            0,
            [
                'creator_id'  => auth()->id(),
                'description' => $withdrawData['description'],
            ]
        );

        flash(__('transaction.withdraw_success'), 'success');

        return redirect()->route('profile.transactions.index', $user);
    }

    public function transfer(Request $request, User $sender, User $receiver)
    {
        $this->authorize('transfer-wallet', $sender);

        $transferData = $request->validate([
            'amount'       => 'required|numeric|max:'.$sender->wallet,
            'description'  => 'required|string|max:255',
            'double_check' => 'required|accepted',
        ], [
            'amount.max' => __('transaction.insufficient_wallet', ['amount' => $sender->wallet]),
        ]);

        Transaction::create([
            'type'        => 'transfer',
            'amount'      => $transferData['amount'],
            'description' => $transferData['description'],
            'receiver_id' => $receiver->id,
            'sender_id'   => $sender->id,
            'creator_id'  => auth()->id(),
        ]);
        $sender->decrement('wallet', $transferData['amount']);
        $receiver->increment('wallet', $transferData['amount']);

        $flashMessageData = [
            'sender'   => $sender->name,
            'receiver' => $receiver->name,
            'amount'   => $transferData['amount'],
        ];
        flash(__('transaction.transfer_success', $flashMessageData), 'success');

        return redirect()->route('profile.transactions.index', $sender);
    }
}
