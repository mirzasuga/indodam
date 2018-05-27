<?php

namespace Tests\Unit\Policies;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class UserPolicyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_create_user()
    {
        $admin = $this->loginAsAdmin();
        $this->assertFalse($admin->can('create', new User));
    }

    /** @test */
    public function user_can_create_their_member()
    {
        $user = $this->createUser('member');
        $this->assertTrue($user->can('add-member', $user));
    }

    /** @test */
    public function admin_can_view_any_user_profile()
    {
        $admin = $this->createUser('admin');
        $user = factory(User::class)->create();
        $this->assertTrue($admin->can('view', $user));
    }

    /** @test */
    public function member_cannot_view_any_other_member_profile()
    {
        $member = $this->createUser('member');
        $otherMember = $this->createUser('member', ['sponsor_id' => 9999]);
        $this->assertFalse($member->can('view', $otherMember));
    }

    /** @test */
    public function member_can_only_view_their_member_profile()
    {
        $member = $this->createUser('member');
        $otherMember = $this->createUser('member', ['sponsor_id' => $member->id]);
        $this->assertTrue($member->can('view', $otherMember));
    }

    /** @test */
    public function admin_can_see_detail_of_their_member_profile()
    {
        $admin = $this->createUser('admin');
        $member = $this->createUser('member');
        $this->assertTrue($admin->can('see-detail', $member));
    }

    /** @test */
    public function member_cannot_see_detail_of_their_member_profile()
    {
        $member = $this->createUser('member');
        $otherMember = $this->createUser('member', ['sponsor_id' => $member->id]);
        $this->assertFalse($member->can('see-detail', $otherMember));
    }

    /** @test */
    public function admin_can_update_user()
    {
        $admin = $this->loginAsAdmin();
        $user = factory(User::class)->create();
        $this->assertTrue($admin->can('update', $user));
    }

    /** @test */
    public function admin_cannot_delete_user()
    {
        $admin = $this->loginAsAdmin();
        $user = factory(User::class)->create();
        $this->assertFalse($admin->can('delete', $user));
    }

    /** @test */
    public function user_can_transfer_wallet_to_5_levels_of_uplines_and_downlines()
    {
        $uplineLevel5 = $this->createUser('member');
        $uplineLevel4 = $this->createUser('member', ['sponsor_id' => $uplineLevel5]);
        $uplineLevel3 = $this->createUser('member', ['sponsor_id' => $uplineLevel4]);
        $uplineLevel2 = $this->createUser('member', ['sponsor_id' => $uplineLevel3]);
        $uplineLevel1 = $this->createUser('member', ['sponsor_id' => $uplineLevel2]);
        $user = $this->createUser('member', ['sponsor_id' => $uplineLevel1]);

        $this->assertTrue($user->can('transfer-to', $uplineLevel1));
        $this->assertTrue($uplineLevel1->can('transfer-to', $user));

        $this->assertTrue($user->can('transfer-to', $uplineLevel2));
        $this->assertTrue($uplineLevel2->can('transfer-to', $user));

        $this->assertTrue($user->can('transfer-to', $uplineLevel3));
        $this->assertTrue($uplineLevel3->can('transfer-to', $user));

        $this->assertTrue($user->can('transfer-to', $uplineLevel4));
        $this->assertTrue($uplineLevel4->can('transfer-to', $user));

        $this->assertTrue($user->can('transfer-to', $uplineLevel5));
        $this->assertTrue($uplineLevel5->can('transfer-to', $user));
    }

    /** @test */
    public function user_cannot_transfer_wallet_to_uplines_and_downlines()
    {
        $uplineLevel6 = $this->createUser('member');
        $uplineLevel5 = $this->createUser('member', ['sponsor_id' => $uplineLevel6]);
        $uplineLevel4 = $this->createUser('member', ['sponsor_id' => $uplineLevel5]);
        $uplineLevel3 = $this->createUser('member', ['sponsor_id' => $uplineLevel4]);
        $uplineLevel2 = $this->createUser('member', ['sponsor_id' => $uplineLevel3]);
        $uplineLevel1 = $this->createUser('member', ['sponsor_id' => $uplineLevel2]);
        $user = $this->createUser('member', ['sponsor_id' => $uplineLevel1]);

        $this->assertFalse($user->can('transfer-to', $uplineLevel6));
        $this->assertFalse($uplineLevel6->can('transfer-to', $user));
    }

    /** @test */
    public function user_cannot_transfer_wallet_to_non_upline_or_downline()
    {
        $sponsor = $this->createUser('member');
        $otherUser = $this->createUser('member');
        $user = $this->createUser('member');

        $this->assertFalse($user->can('transfer-to', $otherUser));
        $this->assertFalse($otherUser->can('transfer-to', $user));
    }

    /** @test */
    public function user_and_admin_has_access_to_wallet_transfer_feature()
    {
        $admin = $this->createUser('admin');
        $user = $this->createUser('member');
        $otherUser = $this->createUser('member');

        $this->assertTrue($admin->can('transfer-wallet', $user));
        $this->assertTrue($user->can('transfer-wallet', $user));
        $this->assertFalse($otherUser->can('transfer-wallet', $user));
    }
}
