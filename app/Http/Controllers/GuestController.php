<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class GuestController extends Controller
{
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return view('guest.register');
    }

    public function create(RegisterRequest $registerRequest) {
        $registerRequest->validateRegister();
        $premember = $registerRequest->approve();
        
        session()->flash('flash_notification',[
            'message' => 'Berhasil mendaftar, silahkan login',
            'level' => 'info'
        ]);

        return redirect()->route('login');

    }
}
