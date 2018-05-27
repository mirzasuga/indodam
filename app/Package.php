<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Option;

class Package extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'wallet',
        'system_portion', 'creator_id',
    ];

    public function nameLink()
    {
        return link_to_route('packages.show', $this->name, [$this], [
            'title' => trans(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => trans('package.package')]
            ),
        ]);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function getSponsorBonusTotalAttribute()
    {
        $sponsorBonusList = json_decode(Option::get('sponsor_bonus'), true);
        if (!is_null($sponsorBonusList)) {
            $packageBonusList = $sponsorBonusList[$this->id] ?? [];
            return array_sum($packageBonusList);
        }
        return 0;
    }

    public function getWalletThresholdAttribute()
    {
        return $this->wallet + $this->system_portion + $this->sponsor_bonus_total;
    }
}
