<?php

namespace Tests\Unit\Models;

use App\Package;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class PackageTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_package_has_name_link_method()
    {
        $package = factory(Package::class)->create();

        $this->assertEquals(
            link_to_route('packages.show', $package->name, [$package], [
                'title' => trans(
                    'app.show_detail_title',
                    ['name' => $package->name, 'type' => trans('package.package')]
                ),
            ]), $package->nameLink()
        );
    }

    /** @test */
    public function a_package_has_belongs_to_creator_relation()
    {
        $package = factory(Package::class)->make();

        $this->assertInstanceOf(User::class, $package->creator);
        $this->assertEquals($package->creator_id, $package->creator->id);
    }

    /** @test */
    public function a_package_has_sponsor_bonus_total_attribute()
    {
        $package = factory(Package::class)->create();

        \DB::table('site_options')->insert([
            'key'   => 'sponsor_bonus',
            'value' => '{"'.$package->id.'":{"1":"200","2":"60","3":"40","4":"20","5":"10"}}',
        ]);

        $this->assertEquals(330, $package->sponsor_bonus_total);
    }

    /** @test */
    public function a_package_has_wallet_threshold_attribute()
    {
        $package = factory(Package::class)->create([
            'wallet'         => 200,
            'system_portion' => 100,
        ]);

        \DB::table('site_options')->insert([
            'key'   => 'sponsor_bonus',
            'value' => '{"'.$package->id.'":{"1":"200","2":"60","3":"40","4":"20","5":"10"}}',
        ]);

        $this->assertEquals(630, $package->wallet_threshold);
    }
}
