<?php

namespace App\Http\Requests\Users;

use App\Events\Members\Registered;
use App\Package;
use App\User;
use DB;
use Illuminate\Foundation\Http\FormRequest;

class MemberCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('add-member', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'package_id'      => 'required|numeric|exists:packages,id',
            'name'            => 'required|min:5|max:60',
            'username'        => 'required|alpha_dash|min:5|max:60|unique:users,username',
            'username_edinar' => 'nullable|min:5|max:60|unique:users,username_edinar',
            'email'           => 'required|email|unique:users,email',
            'phone'           => 'nullable|string|max:255|unique:users,phone',
            'city'            => 'required|string|max:60',
            'address'         => 'nullable|string|max:255',
            'password'        => 'required|between:5,15',
        ];
    }

    /**
     * Approve user creation after passed validation
     *
     * @return \App\User
     */
    public function approve()
    {
        $newUserData = $this->validated();
        $sponsor = $this->route('user');

        $newUserData['password'] = bcrypt($newUserData['password']);
        $newUserData['sponsor_id'] = $sponsor->id;
        $newUserData['role_id'] = 2;

        DB::beginTransaction();
        $newMember = User::create($newUserData);

        $package = Package::find($newUserData['package_id']);
        $newMember->depositWallet($package->wallet, 'new_member', $newUserData['sponsor_id']);

        event(new Registered($newMember));
        DB::commit();

        return $newMember;
    }
}
