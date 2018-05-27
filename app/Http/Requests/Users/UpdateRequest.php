<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');
        return [
            'name'             => 'required|min:5|max:60',
            'username'         => 'required|alpha_dash|min:5|max:60|unique:users,username,'.$user->id,
            'username_edinar'  => 'nullable|min:5|max:60|unique:users,username_edinar,'.$user->id,
            'password'         => 'nullable|between:5,15',
            'email'            => 'required|email|unique:users,email,'.$user->id,
            'phone'            => 'nullable|string|max:255',
            'city'             => 'required|string|max:255',
            'address'          => 'nullable|string|max:255',
            'indodax_email'    => 'nullable|email|unique:users,indodax_email,'.$user->id,
            'data_brand_key'   => 'nullable|string|max:255',
            'referral_code'    => 'nullable|string|max:255',
            'cloud_link'       => 'nullable|string|max:255',
            'cloud_start_date' => 'nullable|date|date_format:Y-m-d',
            'cloud_end_date'   => 'nullable|date|date_format:Y-m-d',
            'notes'            => 'nullable|string|max:255',
        ];
    }

    public function approve()
    {
        $userData = $this->validated();

        if ($userData['password']) {
            $userData['password'] = bcrypt($userData['password']);
        } else {
            unset($userData['password']);
        }

        $user = $this->route('user');
        $user->update($userData);

        return $user;
    }
}
