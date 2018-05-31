<?php

namespace App\Http\Requests\Mining;

use Illuminate\Foundation\Http\FormRequest;

use App\User;
use DB;
class IncreaseRequest extends FormRequest
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

    public function validateIncrease() {
        $rules = $this->rules();
        $this->validate($rules);
    }

    public function increased(User $user) {
        $data       = $this->validated();
        $amount     = $data['mining_power'];

        DB::beginTransaction();
            $miningUser = $user->mining()->first();
            $miningUser->increaseMiningToMerge( $amount )->save();
            $user->wallet -= $amount;
            $user->save();
        DB::commit();
    }
}
