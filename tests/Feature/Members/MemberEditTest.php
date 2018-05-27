<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MemberEditTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_edit_user_data()
    {
        $this->loginAsAdmin();

        $user = $this->createUser('member');

        $this->visit(route('users.edit', $user));
        $this->seePageIs(route('users.edit', $user));

        $this->submitForm(trans('user.update'), [
            'name'             => 'Change user name',
            'username'         => 'username',
            'username_edinar'  => 'username',
            'email'            => 'member@mail.dev',
            'phone'            => '081234567890',
            'city'             => 'Makassar',
            'address'          => 'Jln. ABC, No. 1, Makassar',
            'indodax_email'    => 'member@mail.dev',
            'referral_code'    => 'RANDOMSTRINGCODE',
            'cloud_link'       => 'RANDOMSTRINGCODE',
            'cloud_start_date' => '2017-02-01',
            'cloud_end_date'   => '2017-03-31',
            'password'         => '',
            'notes'            => '',
            'data_brand_key'   => 'pataca centage psoitis pay korona sheugh prerent snakily moutan indylic mitis erethic millet shewel puist findal',
        ]);

        $this->seePageIs(route('profile.show', $user->fresh()));
        $this->see(trans('user.updated'));
        $this->see('Change user name');
        $this->see('member@mail.dev');

        $this->seeInDatabase('users', [
            'name'             => 'Change user name',
            'username'         => 'username',
            'username_edinar'  => 'username',
            'email'            => 'member@mail.dev',
            'phone'            => '081234567890',
            'city'             => 'Makassar',
            'address'          => 'Jln. ABC, No. 1, Makassar',
            'indodax_email'    => 'member@mail.dev',
            'referral_code'    => 'RANDOMSTRINGCODE',
            'cloud_link'       => 'RANDOMSTRINGCODE',
            'cloud_start_date' => '2017-02-01',
            'cloud_end_date'   => '2017-03-31',
            'notes'            => null,
            'data_brand_key'   => 'pataca centage psoitis pay korona sheugh prerent snakily moutan indylic mitis erethic millet shewel puist findal',
            'role_id'          => 2,
        ]);
    }
}
