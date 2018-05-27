<?php

namespace App;

use App\TransactionType;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'amount', 'type', 'receiver_id',
        'sender_id', 'notes', 'creator_id',
        'description',
    ];

    public function getTypeLabelAttribute()
    {
        return TransactionType::getById($this->type);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'INDODAM System']);
    }

    public function sender()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'INDODAM System']);
    }
}
