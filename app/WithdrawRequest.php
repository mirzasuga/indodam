<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use Illuminate\Support\Str;

use DB;
class WithdrawRequest extends Model
{
    protected $table ='withdraw_requests';
    protected $fillable = [
        'status', 'amount',
        'sender_ip', 'acc_ip',
        'user_id', 'admin_id',
        'requested_at', 'verified_at', 'accepted_at', 'request_token',
    ];

    public function requestedBy() {
        return $this->belongsTo(User::class,'user_id');
    }
    public function acceptedBy() {
        return $this->belongsTo(User::class,'admin_id');
    }

    public static function generateToken() {
        $token = Str::random(70);
        $hasToken = DB::table('withdraw_requests')->where([
            'request_token' => $token,
            'status' => 'request'
        ])->first();
        
        while ($hasToken != null) {

            $token = Str::random(70);
            $hasToken = DB::table('withdraw_requests')->where([
                'request_token' => $token,
                'status' => 'request'
            ])->first();
        }
        return $token;
    }

    public function setVerifiedAt() {
        $this->verified_at = new \DateTime();
    }

    public function verify( $token ) {
        
        $verify = $this->where([
            'request_token' => $token,
            'status' => 'request'
        ])->first();;
        
        if($verify) {

            if( $verify->user_id == auth()->user()->id) {

                $verify->status = 'verified';
                $verify->setVerifiedAt();
                return $verify->save();

            }

        }
        return false;
    }

    public function scopeActive($query,$status = 'request') {
        return $query->where('status',$status);
    }
}
