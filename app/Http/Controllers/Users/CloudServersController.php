<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\User;

class CloudServersController extends Controller
{
    public function index(User $user)
    {
        $this->authorize('see-detail', $user);

        return view('users.cloud-servers', compact('user'));
    }
}
