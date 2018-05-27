<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TransactionEntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_deposit_wallet_to_a_member()
    {
        $admin = $this->loginAsAdmin();
        $user = $this->createUser('member');

        $this->visit(route('profile.transactions.index', [$user, 'action' => 'deposit-wallet']));
        $this->seeElement('a', ['id' => 'deposit-wallet']);

        $this->submitForm(__('transaction.deposit_wallet'), [
            'type'         => 'top_up',
            'amount'       => '99.99',
            'description'  => 'Deskripsi penambahan wallet',
            'double_check' => 'on',
        ]);

        $this->seePageIs(route('profile.transactions.index', $user));
        $this->see(__('transaction.deposit_success'));

        $this->seeInDatabase('transactions', [
            'type'        => 'top_up',
            'amount'      => 99.99,
            'receiver_id' => $user->id,
            'sender_id'   => 0,
            'creator_id'  => $admin->id,
            'description' => 'Deskripsi penambahan wallet',
        ]);

        $this->seeInDatabase('users', [
            'id'     => $user->id,
            'wallet' => 99.99,
        ]);
    }

    /** @test */
    public function admin_can_withdraw_wallet_to_a_member()
    {
        $admin = $this->loginAsAdmin();
        $user = $this->createUser('member', ['wallet' => 100]);

        $this->visit(route('profile.transactions.index', [$user, 'action' => 'withdraw-wallet']));
        $this->seeElement('a', ['id' => 'withdraw-wallet']);

        $this->submitForm(__('transaction.withdraw_wallet'), [
            'type'         => 'cloud_cost',
            'amount'       => '9.99',
            'description'  => 'Deskripsi pengurangan wallet',
            'double_check' => 'on',
        ]);

        $this->seePageIs(route('profile.transactions.index', $user));
        $this->see(__('transaction.withdraw_success'));

        $this->seeInDatabase('transactions', [
            'type'        => 'cloud_cost',
            'amount'      => 9.99,
            'receiver_id' => 0,
            'sender_id'   => $user->id,
            'creator_id'  => $admin->id,
            'description' => 'Deskripsi pengurangan wallet',
        ]);

        $this->seeInDatabase('users', [
            'id'     => $user->id,
            'wallet' => 90.01,
        ]);
    }

    /** @test */
    public function admin_can_check_transfer_ability_between_members()
    {
        $this->loginAsAdmin();
        $nonNetworkMember = $this->createUser('member');
        $sender = $this->createUser('member');
        $receiver = $this->createUser('member', ['sponsor_id' => $sender->id]);

        $this->visit(route('profile.transactions.index', [$sender, 'action' => 'transfer']));
        $this->submitForm(__('transaction.select_receiver'), [
            'receiver_username' => $receiver->username,
        ]);
        $this->seePageIs(route('profile.transactions.index', [
            $sender,
            'action'            => 'transfer',
            'receiver_username' => $receiver->username,
        ]));

        $this->seeElement('form', ['id' => 'transfer-wallet-form']);

        $this->submitForm(__('transaction.select_receiver'), [
            'receiver_username' => 'nonexistsusername',
        ]);

        $this->see(__('user.not_found'));

        $this->submitForm(__('transaction.select_receiver'), [
            'receiver_username' => $nonNetworkMember->username,
        ]);

        $this->see(__('transaction.not_in_network', ['sender' => $sender->name, 'receiver' => $nonNetworkMember->name]));
    }

    /** @test */
    public function user_can_check_transfer_ability_for_their_network()
    {
        $sender = $this->loginAsUser();
        $nonNetworkMember = $this->createUser('member', ['sponsor_id' => 999]);
        $receiver = $this->createUser('member', ['sponsor_id' => $sender->id]);

        $this->visit(route('profile.transactions.index', [$sender, 'action' => 'transfer']));
        $this->submitForm(__('transaction.select_receiver'), [
            'receiver_username' => $receiver->username,
        ]);
        $this->seePageIs(route('profile.transactions.index', [
            $sender,
            'action'            => 'transfer',
            'receiver_username' => $receiver->username,
        ]));

        $this->seeElement('form', ['id' => 'transfer-wallet-form']);

        $this->submitForm(__('transaction.select_receiver'), [
            'receiver_username' => 'nonexistsusername',
        ]);

        $this->see(__('user.not_found'));

        $this->submitForm(__('transaction.select_receiver'), [
            'receiver_username' => $nonNetworkMember->username,
        ]);

        $this->see(__('transaction.not_in_network', ['sender' => $sender->name, 'receiver' => $nonNetworkMember->name]));
    }

    /** @test */
    public function admin_transfer_between_members_downlines_or_uplines()
    {
        $admin = $this->loginAsAdmin();
        $sender = $this->createUser('member', ['wallet' => 100]);
        $receiver = $this->createUser('member', ['sponsor_id' => $sender->id, 'wallet' => 10]);

        $this->visit(route('profile.transactions.index', [
            $sender,
            'action'            => 'transfer',
            'receiver_username' => $receiver->username,
        ]));

        $this->seeElement('form', ['id' => 'transfer-wallet-form']);

        $this->submitForm(__('transaction.transfer'), [
            'amount'       => '100',
            'description'  => 'Deskripsi transfer wallet',
            'double_check' => 'on',
        ]);

        $this->seePageIs(route('profile.transactions.index', $sender));
        $this->see(
            __('transaction.transfer_success', [
                'sender'   => $sender->name,
                'receiver' => $receiver->name,
                'amount'   => 100,
            ])
        );

        $this->seeInDatabase('transactions', [
            'type'        => 'transfer',
            'amount'      => 100,
            'receiver_id' => $receiver->id,
            'sender_id'   => $sender->id,
            'creator_id'  => $admin->id,
            'description' => 'Deskripsi transfer wallet',
        ]);

        $this->seeInDatabase('users', [
            'id'     => $sender->id,
            'wallet' => 0.00,
        ]);

        $this->seeInDatabase('users', [
            'id'     => $receiver->id,
            'wallet' => 110.00,
        ]);
    }

    /** @test */
    public function user_can_transfer_wallet_to_their_network_members()
    {
        $sender = $this->loginAsUser(['wallet' => 100]);
        $receiver = $this->createUser('member', ['sponsor_id' => $sender->id, 'wallet' => 10]);

        $this->visit(route('profile.transactions.index', [
            $sender,
            'action'            => 'transfer',
            'receiver_username' => $receiver->username,
        ]));

        $this->seeElement('form', ['id' => 'transfer-wallet-form']);

        $this->submitForm(__('transaction.transfer'), [
            'amount'       => '100',
            'description'  => 'Deskripsi transfer wallet',
            'double_check' => 'on',
        ]);

        $this->seePageIs(route('profile.transactions.index', $sender));
        $this->see(
            __('transaction.transfer_success', [
                'sender'   => $sender->name,
                'receiver' => $receiver->name,
                'amount'   => 100,
            ])
        );

        $this->seeInDatabase('transactions', [
            'type'        => 'transfer',
            'amount'      => 100,
            'receiver_id' => $receiver->id,
            'sender_id'   => $sender->id,
            'creator_id'  => $sender->id,
            'description' => 'Deskripsi transfer wallet',
        ]);

        $this->seeInDatabase('users', [
            'id'     => $sender->id,
            'wallet' => 0.00,
        ]);

        $this->seeInDatabase('users', [
            'id'     => $receiver->id,
            'wallet' => 110.00,
        ]);
    }

    /** @test */
    public function admin_can_edit_member_wallet_values()
    {
        $this->loginAsAdmin();

        $user = $this->createUser('member');

        $this->visit(route('profile.transactions.index', [$user, 'action' => 'edit-wallet']));
        $this->seePageIs(route('profile.transactions.index', [$user, 'action' => 'edit-wallet']));

        $this->submitForm(trans('user.wallet_update'), [
            'wallet_edinar' => 20,
        ]);

        $this->seePageIs(route('profile.transactions.index', $user->fresh()));
        $this->see(trans('user.wallet_updated'));

        $this->seeInDatabase('users', [
            'wallet_edinar' => 20,
        ]);
    }
}
