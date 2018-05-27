<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ManageUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_see_user_list()
    {
        $admin = $this->loginAsAdmin();
        $user = $this->createUser('member');

        $this->visit(route('users.index'));
        $this->see($user->name);
        $this->see($admin->name);
    }

    // /** @test */
    // public function admin_can_create_new_user()
    // {
    //     $admin = $this->loginAsAdmin();

    //     $this->visit(route('users.create'));

    //     $this->submitForm(trans('user.create'), [
    //         'username' => 'username',
    //         'email'    => 'user@mail.com',
    //         'password' => 'password',
    //         'name'     => 'Nama User',
    //         'city'     => 'Jakarta',
    //         'role_id'  => 2,
    //     ]);

    //     $this->seePageIs(route('users.index'));
    //     $this->see(trans('user.created'));
    //     $this->see('Nama User');
    //     $this->see('user@mail.com');
    //     $this->seeInDatabase('users', [
    //         'username' => 'username',
    //         'email'    => 'user@mail.com',
    //         'name'     => 'Nama User',
    //         'city'     => 'Jakarta',
    //         'role_id'  => 2,
    //     ]);
    // }

    /** @test */
    public function admin_cannot_delete_a_user()
    {
        $this->loginAsAdmin();

        $user = $this->createUser('member');

        $this->visit(route('users.edit', $user));
        $this->dontSeeElement('a', ['id' => 'del-user-'.$user->id]);
        $this->visit(route('users.edit', [$user, 'action' => 'delete']));
        $this->dontSee(__('app.delete_confirm_button'));

        // $this->seeElement('a', ['id' => 'del-user-'.$user->id]);
        // $this->click('del-user-'.$user->id);
        // $this->seePageIs(route('users.edit', [$user, 'action' => 'delete']));

        // $this->press(__('app.delete_confirm_button'));

        // $this->seePageIs(route('users.index'));
        // $this->see(trans('user.deleted'));

        // $this->dontSeeInDatabase('users', [
        //     'id' => $user->id,
        // ]);
    }

    /** @test */
    public function admin_can_suspend_a_user()
    {
        $admin = $this->loginAsAdmin();
        $user = $this->createUser('member', ['name' => 'Officer name']);

        $this->visit(route('profile.show', $user));

        $this->seeElement('button', ['id' => 'suspend-user']);
        $this->dontSeeElement('button', ['id' => 'activate-user']);

        $this->press('suspend-user');

        $this->seeInDatabase('users', [
            'id'        => $user->id,
            'is_active' => 0,
        ]);

        $this->dontSeeElement('button', ['id' => 'suspend-user']);
        $this->seeElement('button', ['id' => 'activate-user']);
    }

    /** @test */
    public function admin_can_activate_a_suspended_user()
    {
        $admin = $this->loginAsAdmin();
        $user = $this->createUser('member', ['is_active' => 0]);

        $this->visit(route('profile.show', $user));

        $this->dontSeeElement('button', ['id' => 'suspend-user']);
        $this->seeElement('button', ['id' => 'activate-user']);

        $this->press('activate-user');

        $this->seeInDatabase('users', [
            'id'        => $user->id,
            'is_active' => 1,
        ]);

        $this->seeElement('button', ['id' => 'suspend-user']);
        $this->dontSeeElement('button', ['id' => 'activate-user']);
    }
}
