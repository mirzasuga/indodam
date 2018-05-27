<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateRequest as CreateUser;
use App\Http\Requests\Users\UpdateRequest;
use App\User;
use DB;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where(function ($query) {
            $searchQuery = request('q');
            $query->where('name', 'like', '%'.$searchQuery.'%');
            $query->orWhere('username', 'like', '%'.$searchQuery.'%');
            $query->orWhere('username_edinar', 'like', '%'.$searchQuery.'%');
            $query->orWhere('phone', 'like', '%'.$searchQuery.'%');
            $query->orWhere('email', 'like', '%'.$searchQuery.'%');
            $query->orWhere('referral_code', 'like', '%'.$searchQuery.'%');
        })->with('package')->latest()->paginate(50);

        $walletTotal = DB::table('users')->sum('wallet');
        $edinarTotal = DB::table('users')->sum('wallet_edinar');

        return view('users.index', compact('users', 'walletTotal', 'edinarTotal'));
    }

    public function create()
    {
        $this->authorize('create', new User);

        return view('users.create', compact('leaders'));
    }

    public function store(CreateUser $createUserForm)
    {
        $createUserForm->approve();

        flash(trans('user.created'), 'success');

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    public function update(UpdateRequest $updateUserForm, User $user)
    {
        $updateUserForm->approve();

        flash(trans('user.updated'), 'success');

        return redirect()->route('profile.show', $user);
    }

    public function suspend(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $user->is_active = 0;
        $user->save();

        flash(trans('user.suspended'), 'warning');

        return back();
    }

    public function activate(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $user->is_active = 1;
        $user->save();

        flash(trans('user.activated'), 'success');

        return back();
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        $this->validate(request(), [
            'user_id' => 'required',
        ]);

        $routeParam = request()->only('page', 'q');

        if (request('user_id') == $user->id && $user->delete()) {
            flash(__('user.deleted'), 'warning');

            return redirect()->route('users.index', $routeParam);
        }

        flash(__('user.undeleted'), 'error');

        return back();
    }

    public function walletUpdate(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $walletData = $request->validate([
            'wallet_edinar' => 'required|numeric',
        ]);

        $user->wallet_edinar = $walletData['wallet_edinar'];
        $user->save();

        flash(__('user.wallet_updated'), 'success');

        return redirect()->route('profile.transactions.index', $user);
    }
}
