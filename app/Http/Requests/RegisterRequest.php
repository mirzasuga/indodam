<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Events\PrememberRegisteredEvent as RegisteredEvent;
use App\User;
use DB;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'        => 'required|alpha_dash|min:5|max:60|unique:users,username',
            'email'           => 'required|email|unique:users,email',
            'phone'           => 'required|string|max:255|unique:users,phone',
            'password'        => 'required|between:5,15|same:password_confirm',
            'password_confirm'=> 'required|between:5,15',
            'referal'         => 'nullable|min:5|max:60',
            'g-recaptcha-response' => 'required'
        ];
    }
    public function validateRegister() {
        
        $rules = $this->rules();

        
        $this->validate($rules);
    }

    public function messages() {
        return [
            'g-recaptcha-response.required' => 'Pastikan anda bukan robot.',
        ];
    }
    public function approve() {
        // $newUserData = $this->validated();
        // $sponsor = $this->route('user');

        // $newUserData['password'] = bcrypt($newUserData['password']);
        // $newUserData['sponsor_id'] = $sponsor->id;
        // $newUserData['role_id'] = 2;

        // DB::beginTransaction();
        // $newMember = User::create($newUserData);

        // $package = Package::find($newUserData['package_id']);
        // $newMember->depositWallet($package->wallet, 'new_member', $newUserData['sponsor_id']);

        // event(new Registered($newMember));
        // DB::commit();

        // return $newMember;

        $prememberData = $this->validated();
        $prememberData['password'] = bcrypt($prememberData['password']);

        if(array_key_exists('referal',$prememberData)) {

            $sponsor = User::where('username', $prememberData['referal'])->first();
            $sponsor_id = ($sponsor !== null) ? $sponsor->id : 0;

        }
        DB::beginTransaction();
            $premember = User::create([
                'name' => $prememberData['username'],
                'email' => $prememberData['email'],
                'password' => $prememberData['password'],
                'username' => $prememberData['username'],
                'phone' => $prememberData['phone'],
                'wallet' => 0,
                'wallet_edinar' => 0,
                'package_id' => 0, //as free member
                'role_id' => 2, //ass member
                'sponsor_id' => $sponsor_id,
                'city' => '',
            ]);
            event(new RegisteredEvent($premember) );
        DB::commit();
        return $premember;

    }
}
