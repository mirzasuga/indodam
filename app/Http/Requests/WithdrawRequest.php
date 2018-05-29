<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;
use App\User;
use App\Transaction;
use App\WithdrawRequest as WithdrawRequestModel;
use App\Events\Withdraw\WithdrawRequestedEvent as WithdrawRequestedEvent;

class WithdrawRequest extends FormRequest
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
            'amount' => 'required',
        ];
    }
    public function validateWithdraw() {

        $rules = $this->rules();
        $this->validate($rules);

        $validated = $this->validated();
        $withdrawAmount = $validated['amount'];


    }

    public function store($user) {

        $withdrawData = $this->validated();
        $token  = WithdrawRequestModel::generateToken();
        $user   = auth()->user();
        $amount = $withdrawData['amount'];

        DB::beginTransaction();
            
            $withdrawRequest = WithdrawRequestModel::create([

                'status'        => 'request',
                'amount'        => $amount,
                'sender_ip'     => request()->ip(),
                'user_id'       => $user->id,
                'verified_at'   => null,
                'accepted_at'   => null,
                'request_token' => $token,

            ]);
            event(
                new WithdrawRequestedEvent($user,$withdrawRequest)
            );
        DB::commit();
    }

    public function verifyToken( $token ) {
        $model = new WithdrawRequestModel;
        
        if( $model->verify($token) ) {
            
            session()->flash('flash_notification',[
                'message' => 'Verifikasi Berhasil.',
                'level' => 'info'
            ]);
        }
        else {
            session()->flash('flash_notification',[
                'message' => 'Verifikasi Gagal.',
                'level' => 'danger'
            ]);
        }
        return true;
    }
}
