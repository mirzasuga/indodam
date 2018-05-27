<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\MemberCreateRequest as CreateMember;
use App\Package;
use App\User;

class MembersController extends Controller
{
    public function index(User $user)
    {
        $this->authorize('view', $user);
        $members = $user->members;

        return view('users.members', compact('user', 'members'));
    }

    public function create(User $user)
    {
        $this->authorize('add-member', $user);
        $packages = $this->getPackageList();

        return view('users.member-create', compact('user', 'packages'));
    }

    public function store(CreateMember $createMemberForm, User $user)
    {
        //die('ok');
        $createMemberForm->approve();

        flash(trans('user.created'), 'success');

        return redirect()->route('profile.members.index', compact('user'));
    }

    private function getPackageList()
    {
        $packages = Package::get();

        $packageList = [];

        foreach ($packages as $package) {
            $packageList[$package->id] = $package->name.' ('.$package->wallet.' DAM)'.' - '.formatRp($package->price);
        }

        return $packageList;
    }
}
