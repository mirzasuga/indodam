<?php

namespace Tests\Feature;

use App\Package;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OptionPagesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_visit_settings_page()
    {
        $package = factory(Package::class)->create();
        $this->loginAsAdmin();
        $this->visit(route('options.page-1'));
        $this->seePageIs(route('options.page-1'));
    }

    /** @test */
    public function admin_can_set_due_follow_up_tolerance()
    {
        $package = factory(Package::class)->create();
        $this->loginAsAdmin();
        $this->visit(route('options.page-1'));

        $formFields = [];

        foreach (Package::all() as $package) {
            $formFields['sponsor_bonus['.$package->id.'][1]'] = 200;
            $formFields['sponsor_bonus['.$package->id.'][2]'] = 60;
            $formFields['sponsor_bonus['.$package->id.'][3]'] = 40;
            $formFields['sponsor_bonus['.$package->id.'][4]'] = 20;
            $formFields['sponsor_bonus['.$package->id.'][5]'] = 10;
        }

        $this->submitForm(__('option.update'), $formFields);

        $this->seePageIs(route('options.page-1'));
        $this->see(__('option.updated'));

        $this->seeInDatabase('site_options', [
            'key'   => 'sponsor_bonus',
            'value' => '{"'.$package->id.'":{"1":"200","2":"60","3":"40","4":"20","5":"10"}}',
        ]);
    }
}
