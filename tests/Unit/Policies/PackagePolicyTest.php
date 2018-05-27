<?php

namespace Tests\Unit\Policies;

use App\Package;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class PackagePolicyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_create_package()
    {
        $admin = $this->createUser('admin');
        $this->assertTrue($admin->can('create', new Package));
    }

    /** @test */
    public function admin_can_view_package()
    {
        $admin = $this->createUser('admin');
        $package = factory(Package::class)->create(['name' => 'Package 1 name']);
        $this->assertTrue($admin->can('view', $package));
    }

    /** @test */
    public function admin_can_update_package()
    {
        $admin = $this->createUser('admin');
        $package = factory(Package::class)->create(['name' => 'Package 1 name']);
        $this->assertTrue($admin->can('update', $package));
    }

    /** @test */
    public function admin_can_delete_package()
    {
        $admin = $this->createUser('admin');
        $package = factory(Package::class)->create(['name' => 'Package 1 name']);
        $this->assertTrue($admin->can('delete', $package));
    }

    /** @test */
    public function user_need_enough_wallet_to_register_new_member_based_on_package()
    {
        $user = $this->createUser('member');

        $package = factory(Package::class)->create(['wallet' => 1000, 'system_portion' => 100]);
        \DB::table('site_options')->insert([
            'key'   => 'sponsor_bonus',
            'value' => '{"'.$package->id.'":{"1":"200","2":"60","3":"40","4":"20","5":"10"}}',
        ]);

        $this->assertFalse($user->can('add-member', $package));

        $user->wallet = 1500;
        $this->assertTrue($user->can('add-member', $package));
    }
}
