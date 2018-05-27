<?php

namespace App\Http\Requests\Users;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', new User);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|min:5|max:60|unique:users,username',
            'name'     => 'required|min:5|max:60',
            'email'    => 'required|email|unique:users,email',
            'city'     => 'required|string|max:60',
            'password' => 'required|between:5,15',
            'role_id'  => 'required|numeric',
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

        $password = $newUserData['password'] ?: 'secret';
        $newUserData['password'] = bcrypt($newUserData['password']);
        $newUserData['sponsor_id'] = auth()->id();

        return User::create($newUserData);
    }
}
