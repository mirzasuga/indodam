<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        
        $miningUser = $user->mining()->first();
        $miningUser->startMining( 100 )->save();
    }

    public function validateStop() {
        $this->validate([]);
        $this->stop();
    }
    public function stop(User $user) {
        $miningUser = $user->mining()->first();
        $miningUser->stopMining()->save();
    }
}
