<?php

namespace Tests\Feature;

use App\Package;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class ManagePackagesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_can_see_package_list_in_package_index_page()
    {
        $package = factory(Package::class)->create();

        $this->loginAsAdmin();
        $this->visit(route('packages.index'));
        $this->see($package->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'           => 'Package 1 name',
            'description'    => 'Package 1 description',
            'price'          => '5000000',
            'wallet'         => '2600',
            'system_portion' => '200',
        ], $overrides);
    }

    /** @test */
    public function admin_can_create_a_package()
    {
        $this->loginAsAdmin();
        $this->visit(route('packages.index'));

        $this->click(trans('package.create'));
        $this->seePageIs(route('packages.create'));

        $this->submitForm(trans('package.create'), $this->getCreateFields());

        $this->seePageIs(route('packages.show', Package::first()));

        $this->seeInDatabase('packages', $this->getCreateFields());
    }

    /** @test */
    public function create_package_action_must_pass_validations()
    {
        $this->loginAsAdmin();

        // Name empty
        $this->post(route('packages.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');

        // Name 70 characters
        $this->post(route('packages.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');

        // Description 256 characters
        $this->post(route('packages.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Package 1 name',
            'description' => 'Package 1 description',
        ], $overrides);
    }

    /** @test */
    public function admin_can_edit_a_package()
    {
        $this->loginAsAdmin();
        $package = factory(Package::class)->create(['name' => 'Testing 123']);

        $this->visit(route('packages.show', $package));
        $this->click('edit-package-'.$package->id);
        $this->seePageIs(route('packages.edit', $package));

        $this->submitForm(trans('package.update'), $this->getEditFields());

        $this->seePageIs(route('packages.show', $package));

        $this->seeInDatabase('packages', [
            'id' => $package->id,
        ] + $this->getEditFields());
    }

    /** @test */
    public function edit_package_action_must_pass_validations()
    {
        $this->loginAsAdmin();
        $package = factory(Package::class)->create(['name' => 'Testing 123']);

        // Name empty
        $this->patch(route('packages.update', $package), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');

        // Name 70 characters
        $this->patch(route('packages.update', $package), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');

        // Description 256 characters
        $this->patch(route('packages.update', $package), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function admin_can_delete_a_package()
    {
        $this->loginAsAdmin();
        $package = factory(Package::class)->create();

        $this->visit(route('packages.edit', $package));
        $this->click('del-package-'.$package->id);
        $this->seePageIs(route('packages.edit', [$package, 'action' => 'delete']));

        $this->press(trans('app.delete_confirm_button'));

        $this->dontSeeInDatabase('packages', [
            'id' => $package->id,
        ]);
    }
}
