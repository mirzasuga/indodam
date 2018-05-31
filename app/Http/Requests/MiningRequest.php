<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
class MiningRequest extends FormRequest
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
            'mining_power' => 'required|numeric'
        ];
    }
    public function validateCreate() {
        $this->validate($this->rules());
    }
    public function approve(User $user) {
        $data = $this->validated();
        
        $miningUser = $user->mining()->first();
        $miningUser->startMining( $data['mining_power'] )->save();

        $user->wallet -= $data['mining_power'];
        $user->save();
    }

    
}
