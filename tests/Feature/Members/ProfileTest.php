<?php

namespace Tests\Feature\Members;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_see_any_user_profile_page()
    {
        $admin = $this->loginAsAdmin();
        $user = $this->createUser('member', ['name' => 'Officer name']);

        $this->visit(route('profile.show', $user));
        $this->see('Officer name');
        $this->see($user->email);
        $this->dontSee($admin->email);
    }

    /** @test */
    public function member_can_visit_their_own_profile()
    {
        $member = $this->loginAsUser([
            'name'  => 'User name',
            'email' => 'member@mail.dev',
        ]);
        $otherUser = $this->createUser();

        $this->visit(route('profile.show', $member));
        $this->see('User name');
        $this->see('member@mail.dev');
        $this->dontSee($otherUser->name);
    }

    /** @test */
    public function member_can_only_visit_their_member_profile()
    {
        $user = $this->loginAsUser();
        $member = $this->createUser(['sponsor_id' => $user->id]);
        $this->visit(route('profile.show', $member));
        $this->see($member->name);
        $this->see($member->username);
    }

    /** @test */
    public function member_cannot_visit_other_member_profile()
    {
        $this->loginAsUser();

        try {
            $this->visit(route('profile.show', $this->createUser('member', ['sponsor_id' => 9999])));
        } catch (\Exception $e) {
            return;
        }

        $this->fail('The user cannot visit other user.');
    }
}
