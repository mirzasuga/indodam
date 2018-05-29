<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawRequest;
use Illuminate\Http\Request;

class WithdrawRequestController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        $user = auth()->user();
        $withdraws = $user->withdrawRequest()->get();
        return view('withdraw.show')
            ->with(compact('user'))
            ->with(compact('withdraws'));

    }
    public function store(WithdrawRequest $withdrawRequest) {
        
        $withdrawRequest->validateWithdraw();
        $user = auth()->user();
        $withdrawAmount = $withdrawRequest->amount;
        if( !$user->hasEnoughCoin( $withdrawAmount ) ) {

            session()->flash('flash_notification',[
                'message' => 'Balance anda tidak mencukupi',
                'level' => 'error'
            ]);
            return redirect()->back();

        }

        $withdrawRequest->store( $user );


        $this->storeSuccessMessage();
        return redirect()->route('withdraw.index', compact('user'));
    }
    public function verify($token) {

        $user = auth()->user();
        $request = new WithdrawRequest();
        $request->verifyToken( $token );
        
        return redirect()->route('profile.members.index',compact('user'));

    }
    public function approve(Request $request) {

    }
    public function storeSuccessMessage() {

        return session()->flash('flash_notification',[
            'message' => 'Berhasil mengirim permintaan withdraw, silahkan cek email anda.',
            'level' => 'info'
        ]);

    }
    
}
