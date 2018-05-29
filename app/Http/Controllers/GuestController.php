<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Rules\Recaptcha;

class GuestController extends Controller
{
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return view('guest.register');
    }

    public function create(RegisterRequest $registerRequest) {
        $rules = $registerRequest->rules();
        // $registerRequest->validateRegister();
        
        if (!app()->runningUnitTests()) {
            $rules['g-recaptcha-response'] = ['required', new Recaptcha()];
        }

        $registerRequest->validate($rules);

        $premember = $registerRequest->approve();
        
        session()->flash('flash_notification',[
            'message' => 'Berhasil mendaftar, silahkan login',
            'level' => 'info'
        ]);

        return redirect()->route('login');

    }
}
