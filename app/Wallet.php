<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Wallet extends Model
{
    protected $fillable = [
        'id',
        'balance_dam',
        'balance_edinar',
        'mining_balance',
        'merge_to_mining',
        'mining_income',
        'virtual_balance',
        'started_mining',
        'end_mining',
        'member_id',
        'created_at',
        'updated_at'
    ];
    protected $dates = ['start_mining', 'created_at', 'updated_at','end_mining'];

    /**
     * when user is active mining deposit balance will insert into balance to merge
     * next day will be merging to balance dam field in table wallet which having by user
     */
    public static function setBalanceToMerge( User $user, $amount ) {

        $walletUser = $user->wallet()->first();
        $walletUser->balance_dam = $amount;
        $walletUser->save();
        return true;
    }
    /**
     * Topup Main DAM
     */
    public function incrementDam($amount) {


        $this->balance_dam += $amount;
        return $this;

    }

    public function decrementDam( $amount ) {
        $this->balance_dam -= $amount;
        return $this;
    }

    public function incrementEdinar( $amount ) {
        $this->balance_edinar += $amount;
        return $this;
    }
    
    public function withdrawDam($amount) {
        if( $this->balance_dam >= $amount ) {

            $this->balance_dam -= $amount;
            
        }
        return $this;
    }

    

    public function member() {
        return $this->belongsTo(User::class,'user_id');
    }
}
