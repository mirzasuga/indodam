<?php

namespace App;

use App\Package;
use App\Transaction;
use App\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id',
        'username', 'phone', 'wallet',
        'wallet_edinar', 'username_edinar',
        'indodax_email', 'referral_code', 'package_id',
        'role_id', 'sponsor_id', 'city', 'address',
        'cloud_start_date', 'cloud_end_date', 'notes',
        'data_brand_key', 'cloud_link',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Show user profile link.
     *
     * @return string
     */
    public function nameLink()
    {
        return link_to_route('profile.show', $this->name, [$this], [
            'title' => trans(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => trans('user.user')]
            ),
        ]);
    }

    /**
     * Check weather user is admin or not.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role_id == 1;
    }

    /**
     * Get user role attribute.
     *
     * @return string
     */
    public function getRoleAttribute()
    {
        return Role::getById($this->role_id);
    }

    /**
     * Get user status attribute.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->is_active == 1 ? trans('app.active') : trans('app.in_active');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(User::class, 'sponsor_id');
    }

    public function incomes()
    {
        return $this->hasMany(Transaction::class, 'receiver_id');
    }

    public function outcomes()
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    public function depositWallet(float $walletAmount, string $type = 'top_up', int $senderId = 0, array $transactionData = [])
    {
        $this->increment('wallet', $walletAmount);
        $newTransactionData = array_merge([
            'type'        => $type,
            'amount'      => $walletAmount,
            'receiver_id' => $this->id,
            'sender_id'   => $senderId,
        ], $transactionData);
        Transaction::create($newTransactionData);

        return $this;
    }

    public function withdrawWallet(float $walletAmount, string $type = 'top_up', int $receiverId = 0, array $transactionData = [])
    {
        $this->decrement('wallet', $walletAmount);
        $newTransactionData = array_merge([
            'type'        => $type,
            'amount'      => $walletAmount,
            'receiver_id' => $receiverId,
            'sender_id'   => $this->id,
        ], $transactionData);
        Transaction::create($newTransactionData);

        return $this;
    }
}
