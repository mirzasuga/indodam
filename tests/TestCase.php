<?php

namespace Tests;

use App\User;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $baseUrl = 'http://localhost';

    protected function loginAsAdmin($userDataOverrides = [])
    {
        $user = $this->createUser('admin', $userDataOverrides);
        $this->actingAs($user);

        return $user;
    }

    protected function loginAsUser($userDataOverrides = [])
    {
        $user = $this->createUser('member', $userDataOverrides);
        $this->actingAs($user);

        return $user;
    }

    protected function createUser($role = 'member', $userDataOverrides = [])
    {
        if ($role == 'admin') {
            $userDataOverrides = array_merge(['role_id' => 1], $userDataOverrides);
        }

        $userDataOverrides = array_merge(['role_id' => 2], $userDataOverrides);
        $user = factory(User::class)->create($userDataOverrides);

        return $user;
    }
}
