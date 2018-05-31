<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Wallet;
use App\User;
use Carbon\Carbon;
class Mining extends Wallet
{
    protected $table = 'wallets';
    
    public function startMining($amount) {
        
        $this->started_mining = new Carbon();
        $this->end_mining = $this->started_mining->addDays(30);
        $this->increaseMiningBalance( $amount );
        return $this;
    }
    public function stopMining() {
        $this->started_mining = null;
        $this->end_mining = null;
        $this->balance_dam += $this->mining_balance + $this->mining_income;
        $this->mining_balance = 0;
        $this->mining_income = 0;
        return $this;
    }

    public function mergeToMining() {
        
        $this->mining_balance += $this->merge_to_mining;
        $this->merge_to_mining = 0;

        return $this;
    }

    public function increaseMiningBalance($amount) {

        $this->merge_to_mining += $amount;
        $this->balance_dam -= $amount;

        return $this;
    }

    public function virtualMiningBalance() {

        return $this->mining_balance + $this->merge_to_mining;
        
    }
    public function miningIncome() {
        
    }
}
