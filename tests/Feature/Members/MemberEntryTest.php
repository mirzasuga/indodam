<?php

namespace Tests\Feature\Members;

use App\Package;
use App\User;
use DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MemberEntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_add_their_member()
    {
        $startingWallet = 1000;
        $package = factory(Package::class)->create(['wallet' => $startingWallet]);
        $user = $this->loginAsUser(['wallet' => 90000]);

        $this->visit(route('profile.members.index', $user));
        $this->seeElement('a', ['id' => 'add-member-'.$user->id]);

        $this->click('add-member-'.$user->id);
        $this->seePageIs(route('profile.members.create', $user));

        $this->expectsEvents('App\Events\Members\Registered');

        $this->submitForm(trans('member.create'), $this->newMemberFormData($package));

        $this->seePageIs(route('profile.members.index', $user));
        $this->see(trans('user.created'));
        $this->seeInDatabase('users', [
            'name'       => 'Nama User',
            'username'   => 'username',
            'email'      => 'user@mail.com',
            'phone'      => '081234567890',
            'city'       => 'Jakarta',
            'address'    => 'Jln. Kalimantan, No. 1, Jakarta',
            'wallet'     => $startingWallet,
            'package_id' => $package->id,
            'role_id'    => 2,
        ]);
    }

    /** @test */
    public function sponsors_gets_wallet_bonus_after_registering_new_member()
    {
        $startingWallet = 1000;
        $systemPortion = 1000;
        $package = factory(Package::class)->create([
            'wallet'         => $startingWallet,
            'system_portion' => $systemPortion,
        ]);

        DB::table('site_options')->insert([
            'key'   => 'sponsor_bonus',
            'value' => '{"'.$package->id.'":{"1":"200","2":"60","3":"40","4":"20","5":"10"}}',
        ]);

        $userSponsor6 = $this->createUser('member', ['package_id' => $package->id]);
        $userSponsor5 = $this->createUser('member', ['package_id' => $package->id, 'sponsor_id' => $userSponsor6]);
        $userSponsor4 = $this->createUser('member', ['package_id' => $package->id, 'sponsor_id' => $userSponsor5]);
        $userSponsor3 = $this->createUser('member', ['package_id' => $package->id, 'sponsor_id' => $userSponsor4]);
        $userSponsor2 = $this->createUser('member', ['package_id' => $package->id, 'sponsor_id' => $userSponsor3]);
        $userSponsor1 = $this->loginAsUser(['wallet' => 9000, 'package_id' => $package->id, 'sponsor_id' => $userSponsor2]);

        $this->post(route('profile.members.store', $userSponsor1), $this->newMemberFormData($package));

        $newUser = User::orderBy('id', 'desc')->first();

        // System portion transaction
        $this->seeInDatabase('transactions', [
            'amount'      => $systemPortion,
            'type'        => 'new_member_bonus',
            'receiver_id' => 0,
            'sender_id'   => $userSponsor1->id,
        ]);

        // New User wallet transaction
        $this->seeInDatabase('users', [
            'id'         => $newUser->id,
            'wallet'     => $startingWallet,
            'package_id' => $package->id,
        ]);
        $this->seeInDatabase('transactions', [
            'amount'      => $startingWallet,
            'type'        => 'new_member',
            'receiver_id' => $newUser->id,
            'sender_id'   => $userSponsor1->id,
        ]);

        // Level 1 Sponsor (current user) wallet transaction
        $this->seeInDatabase('users', [
            'id'     => $userSponsor1->id,
            'wallet' => 6870, // 9000 - 2330 + 200
        ]);
        $this->seeInDatabase('transactions', [
            'amount'      => 200,
            'type'        => 'new_member_bonus',
            'receiver_id' => $userSponsor1->id,
            'sender_id'   => $userSponsor1->id,
        ]);

        // Level 2 Sponsor wallet transaction
        $this->seeInDatabase('users', [
            'id'     => $userSponsor2->id,
            'wallet' => 60,
        ]);
        $this->seeInDatabase('transactions', [
            'amount'      => 60,
            'type'        => 'new_member_bonus',
            'receiver_id' => $userSponsor2->id,
            'sender_id'   => $userSponsor1->id,
        ]);

        // Level 3 Sponsor wallet transaction
        $this->seeInDatabase('users', [
            'id'     => $userSponsor3->id,
            'wallet' => 40,
        ]);
        $this->seeInDatabase('transactions', [
            'amount'      => 40,
            'type'        => 'new_member_bonus',
            'receiver_id' => $userSponsor3->id,
            'sender_id'   => $userSponsor1->id,
        ]);

        // Level 4 Sponsor wallet transaction
        $this->seeInDatabase('users', [
            'id'     => $userSponsor4->id,
            'wallet' => 20,
        ]);
        $this->seeInDatabase('transactions', [
            'amount'      => 20,
            'type'        => 'new_member_bonus',
            'receiver_id' => $userSponsor4->id,
            'sender_id'   => $userSponsor1->id,
        ]);

        // Level 5 Sponsor wallet transaction
        $this->seeInDatabase('users', [
            'id'     => $userSponsor5->id,
            'wallet' => 10,
        ]);
        $this->seeInDatabase('transactions', [
            'amount'      => 10,
            'type'        => 'new_member_bonus',
            'receiver_id' => $userSponsor5->id,
            'sender_id'   => $userSponsor1->id,
        ]);

        // Level 6 Sponsor wallet transaction
        $this->seeInDatabase('users', [
            'id'     => $userSponsor6->id,
            'wallet' => 0,
        ]);
        $this->dontSeeInDatabase('transactions', [
            'type'        => 'new_member_bonus',
            'receiver_id' => $userSponsor6->id,
            'sender_id'   => $userSponsor1->id,
        ]);
    }

    private function newMemberFormData(Package $package)
    {
        return [
            'name'       => 'Nama User',
            'username'   => 'username',
            'email'      => 'user@mail.com',
            'phone'      => '081234567890',
            'city'       => 'Jakarta',
            'address'    => 'Jln. Kalimantan, No. 1, Jakarta',
            'password'   => '123456',
            'package_id' => $package->id,
        ];
    }
}
