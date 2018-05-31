<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Wallet;
use App\User;
use Carbon\Carbon;
class Mining extends Wallet
{
    const MIN_MINING_DAY = 30;
    const DAILY_MINING_PERCENTAGE = 0.5;

    protected $table = 'wallets';
    
    public function startMining($amount) {
        
        $this->started_mining = Carbon::now();
        $this->end_mining = Carbon::now();
        $this->end_mining = $this->end_mining->addDays(30);
        $this->increaseMiningBalance( $amount );
        $user = $this->user()->first();
        $user->wallet -= $amount;
        $user->save();

        return $this;
    }
    public function stopMining() {

        $this->started_mining = null;
        $this->end_mining = null;

        $total = $this->mining_balance + $this->mining_income + $this->merge_to_mining;


        $user = $this->user()->first();

        //increment to balance_dam and wallet user
        $this->balance_dam += $total;
        $user->wallet += $total;
        $user->save();

        $this->mining_balance = 0;
        $this->mining_income = 0;
        return $this;

    }
    public function increaseMiningToMerge( $amount ) {
        
        $this->merge_to_mining += $amount;
        $this->decrementDam( $amount );
        return $this;

    }

    public function isCanStop() {

        $now = Carbon::now();
        $start = Carbon::parse($this->started_mining);
        return $start->diffInDays( $now ) >= self::MIN_MINING_DAY;

    }
    public function whenCanStop() {
        $now = Carbon::now();
        $start = Carbon::parse($this->started_mining);
        $when = self::MIN_MINING_DAY - $start->diffInDays( $now );
        return self::MIN_MINING_DAY - $start->diffInDays( $now );
    }

    public function mergeToMining() {
        
        $this->mining_balance += $this->merge_to_mining;
        $this->merge_to_mining = 0;

        return $this;
    }

    public function increaseMiningBalance($amount) {

        $this->mining_balance += $amount;
        $this->balance_dam -= $amount;

        return $this;
    }

    public function virtualMiningBalance() {

        return $this->mining_balance + $this->merge_to_mining;
        
    }
    public function grabIncomeDaily() {

        $income = ($this->mining_balance * self::DAILY_MINING_PERCENTAGE) / 100;
        $this->mining_income += $income;
        return $this;

    }
    public function scopeActiveMining($query) {
        
        return $query
            ->whereNotNull('started_mining')
            ->whereNotNull('end_mining')
            ->where('mining_balance','>',0);
            
    }
    public function user() {
        return $this->belongsTo(User::class,'member_id');
    }
}
