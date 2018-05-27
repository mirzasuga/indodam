<?php

namespace Tests\Unit\Models;

use App\Package;
use App\Transaction;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_has_name_link_method()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(
            link_to_route('profile.show', $user->name, [$user], [
                'title' => trans(
                    'app.show_detail_title',
                    ['name' => $user->name, 'type' => trans('user.user')]
                ),
            ]), $user->nameLink()
        );
    }

    /** @test */
    public function a_user_has_role_attribute()
    {
        $user = factory(User::class)->make(['role_id' => 1]);
        $this->assertEquals(trans('user.admin'), $user->role);

        $user = factory(User::class)->make(['role_id' => 2]);
        $this->assertEquals(trans('user.member'), $user->role);
    }

    /** @test */
    public function a_user_has_is_admin_method()
    {
        $user = factory(User::class)->make(['role_id' => 1]);
        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function a_user_has_deposit_wallet_method_and_record_the_transaction()
    {
        $user = $this->createUser();
        $user->depositWallet(99.99, 'top_up');

        $this->assertEquals(99.99, $user->fresh()->wallet);

        $this->seeInDatabase('transactions', [
            'amount'      => 99.99,
            'receiver_id' => $user->id,
        ]);
    }

    /** @test */
    public function a_user_has_status_attribute()
    {
        $user = factory(User::class)->make(['is_active' => 1]);
        $this->assertEquals(trans('app.active'), $user->status);

        $user = factory(User::class)->make(['is_active' => 0]);
        $this->assertEquals(trans('app.in_active'), $user->status);
    }

    /** @test */
    public function a_user_has_belongs_to_package_relation()
    {
        $user = factory(User::class)->make([
            'package_id' => factory(Package::class)->create()->id,
        ]);

        $this->assertInstanceOf(Package::class, $user->package);
        $this->assertEquals($user->package_id, $user->package->id);
    }

    /** @test */
    public function a_user_has_belongs_to_sponsor_relation()
    {
        $user = factory(User::class)->make([
            'sponsor_id' => factory(User::class)->create()->id,
        ]);

        $this->assertInstanceOf(User::class, $user->sponsor);
        $this->assertEquals($user->sponsor_id, $user->sponsor->id);
    }

    /** @test */
    public function a_user_has_many_members_relation()
    {
        $user = factory(User::class)->create();
        $member = factory(User::class)->create(['sponsor_id' => $user->id]);

        $this->assertInstanceOf(Collection::class, $user->members);
        $this->assertInstanceOf(User::class, $user->members->first());
    }

    /** @test */
    public function a_user_has_many_incomes_relation()
    {
        $user = factory(User::class)->create();
        $income = factory(Transaction::class)->create([
            'type'        => 'top_up',
            'amount'      => 100,
            'receiver_id' => $user->id,
        ]);

        $this->assertInstanceOf(Collection::class, $user->incomes);
        $this->assertInstanceOf(Transaction::class, $user->incomes->first());
    }

    /** @test */
    public function a_user_has_many_outcomes_relation()
    {
        $user = factory(User::class)->create();
        $outcome = factory(Transaction::class)->create([
            'type'        => 'new_member_bonus',
            'amount'      => 100,
            'receiver_id' => $user->id,
            'sender_id'   => 1,
        ]);

        $this->assertInstanceOf(Collection::class, $user->outcomes);
        $this->assertInstanceOf(Transaction::class, $user->outcomes->first());
    }
}
