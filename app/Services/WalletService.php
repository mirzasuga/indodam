<?php

namespace App\Services;

use App\Wallet;

/**
 * 
 *
 * @author Mirza <sugamirza@gmail.com>
 */
class WalletService
{

    public function __construct() {
    }

    public static function initialize( $premember ) {

        return Wallet::create([
            'balance_dam' => 0,
            'balance_edinar' => 0,
            'balance_to_merge' => 0,
            'virtual_balance' => 0,
            'member_id' => $premember->id
        ]);
    }
}