<?php

namespace App\Http\Requests\Mining;

use Illuminate\Foundation\Http\FormRequest;

use App\User;
use DB;
class StopRequest extends FormRequest
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
            //
        ];
    }
    public function validateStop($userMining) {
        
        if($userMining->isCanStop()) {
            $user = $userMining->user()->first();
            $this->stop($user);
        }
        else {
            $days = $userMining->whenCanStop();
            session()->flash('flash_notification',[
                'message' => "Anda belum bisa berhenti mining, tersisa $days hari lagi.",
                'level' => 'error'
            ]);
        }
    }
    public function stop(User $user) {
        
        DB::beginTransaction();
            $miningUser = $user->mining()->first();
            $miningUser->stopMining()->save();
        DB::commit();

    }
}
