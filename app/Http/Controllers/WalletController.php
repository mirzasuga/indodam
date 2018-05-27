<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Wallet;

class WalletController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(Request $request) {

        $user = auth()->user();
        $wallet = $user->wallet()->first();

    }
    /**
     * Initialize wallet when user register
     */
    public function create(User $user) {
        // $wallet = new Wallet::create([
        //     ''
        // ])
    }
}
