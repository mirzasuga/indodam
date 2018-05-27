<?php

namespace App;

use App\ReferenceAbstract;

/**
 * Transaction Type Class
 */
class TransactionType extends ReferenceAbstract
{
    protected static $lists = [
        'transfer'             => 'Transfer Wallet',
        'new_member'           => 'Top UP Registrasi',
        'new_member_bonus'     => 'Bonus Member Baru',
        'top_up'               => 'Top UP Wallet DAM',
        'edinar_withdraw'      => 'Withdraw dari Edinar',
        'sharenview_commision' => 'Komisi Publisher Sharenview',
        'correction'           => 'Koreksi Nilai',
        'cloud_cost'           => 'Biaya Cloud',
        'edinar_top_up'        => 'Top Up Edinar',
        'indodax_withdraw'     => 'Withdraw ke Indodax',
        'sharenview_payment'   => 'Bayar Iklan Sharenview',
    ];

    public static function getDepositTypeList()
    {
        return [
            'top_up'               => 'Top UP Wallet DAM',
            'edinar_withdraw'      => 'Withdraw dari Edinar',
            'sharenview_commision' => 'Komisi Publisher Sharenview',
            'correction'           => 'Koreksi Nilai',
        ];
    }

    public static function getWithdrawTypeList()
    {
        return [
            'cloud_cost'         => 'Biaya Cloud',
            'edinar_top_up'      => 'Top Up ke Edinar',
            'indodax_withdraw'   => 'Withdraw ke Indodax',
            'sharenview_payment' => 'Bayar Iklan Sharenview',
            'correction'         => 'Koreksi Nilai',
        ];
    }
}
