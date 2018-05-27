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
        'balance_to_merge',
        'virtual_balance',
        'member_id',
        'created_at',
        'updated_at'
    ];

    public function member() {
        return $this->belongsTo(User::class,'user_id');
    }
}
