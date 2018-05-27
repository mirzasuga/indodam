<?php

namespace App\Listeners\Members;

use App\Events\Members\Registered;
use App\Transaction;
use Option;

class RegisteredListener
{
    public function handle(Registered $event)
    {
        $newMember = $event->newMember;
        $walletBonusList = json_decode(Option::get('sponsor_bonus'), true);

        $sponsorLevel1 = $newMember->sponsor;

        $sponsorLevel1->wallet -= $newMember->package->wallet_threshold;

        $sponsorLevel1->save();

        Transaction::create([
            'type'        => 'new_member_bonus',
            'amount'      => $newMember->package->system_portion,
            'receiver_id' => 0,
            'sender_id'   => $sponsorLevel1->id,
        ]);

        if (!is_null($sponsorLevel1)) {
            $sponsorLevel1->depositWallet(
                $walletBonusList[$newMember->package_id]['1'],
                'new_member_bonus',
                $sponsorLevel1->id
            );

            $sponsorLevel2 = $sponsorLevel1->sponsor;
            if (!is_null($sponsorLevel2)) {
                $sponsorLevel2->depositWallet(
                    $walletBonusList[$newMember->package_id]['2'],
                    'new_member_bonus',
                    $sponsorLevel1->id
                );

                $sponsorLevel3 = $sponsorLevel2->sponsor;
                if (!is_null($sponsorLevel3)) {
                    $sponsorLevel3->depositWallet(
                        $walletBonusList[$newMember->package_id]['3'],
                        'new_member_bonus',
                        $sponsorLevel1->id
                    );

                    $sponsorLevel4 = $sponsorLevel3->sponsor;
                    if (!is_null($sponsorLevel4)) {
                        $sponsorLevel4->depositWallet(
                            $walletBonusList[$newMember->package_id]['4'],
                            'new_member_bonus',
                            $sponsorLevel1->id
                        );

                        $sponsorLevel5 = $sponsorLevel4->sponsor;
                        if (!is_null($sponsorLevel5)) {
                            $sponsorLevel5->depositWallet(
                                $walletBonusList[$newMember->package_id]['5'],
                                'new_member_bonus',
                                $sponsorLevel1->id
                            );
                        }
                    }
                }
            }
        }
    }
}
