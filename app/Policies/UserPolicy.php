<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $authUser
     * @param  \App\User  $userObject
     * @return mixed
     */
    public function view(User $authUser, User $userObject)
    {
        // All authenticated user can see other user profile page.
        return $authUser->isAdmin()
        || $authUser->id == $userObject->id
        || $authUser->id == $userObject->sponsor_id;
    }

    /**
     * Determine whether the user can view the user detail.
     *
     * @param  \App\User  $authUser
     * @param  \App\User  $userObject
     * @return mixed
     */
    public function seeDetail(User $authUser, User $userObject)
    {
        // All authenticated user can see other user detail.
        return $authUser->isAdmin() || $authUser->id == $userObject->id;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param \App\User $authUser
     * @param \App\User $userObject
     *
     * @return mixed
     */
    public function create(User $authUser, User $userObject)
    {
        // Only admin who can create new user.
        return false;
    }

    /**
     * Determine whether the user can add their own member.
     *
     * @param \App\User $authUser
     * @param \App\User $userObject
     *
     * @return mixed
     */
    public function addMember(User $authUser, User $userObject)
    {
        // Only admin who can create new user.
        return $authUser->isAdmin() || $authUser->id == $userObject->id;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param \App\User $authUser
     * @param \App\User $userObject
     *
     * @return mixed
     */
    public function update(User $authUser, User $userObject)
    {
        // Currently only admin can edit user data.
        return $authUser->isAdmin();
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param \App\User $authUser
     * @param \App\User $userObject
     *
     * @return mixed
     */
    public function delete(User $authUser, User $userObject)
    {
        // No one can delete user.
        return false;
    }

    public function transferTo(User $sender, User $receiver)
    {
        if ($sender->id == $receiver->sponsor_id) {
            return true;
        }
        if ($receiver->id == $sender->sponsor_id) {
            return true;
        }

        $senderUplineLevel1 = $sender->sponsor;
        if ($senderUplineLevel1) {
            if ($senderUplineLevel1->sponsor_id == $receiver->id) {
                return true;
            }

            $senderUplineLevel2 = $senderUplineLevel1->sponsor;
            if ($senderUplineLevel2) {
                if ($senderUplineLevel2->sponsor_id == $receiver->id) {
                    return true;
                }

                $senderUplineLevel3 = $senderUplineLevel2->sponsor;
                if ($senderUplineLevel3) {
                    if ($senderUplineLevel3->sponsor_id == $receiver->id) {
                        return true;
                    }

                    $senderUplineLevel4 = $senderUplineLevel3->sponsor;
                    if ($senderUplineLevel4) {
                        if ($senderUplineLevel4->sponsor_id == $receiver->id) {
                            return true;
                        }
                    }
                }
            }
        }

        $receiverUplineLevel1 = $receiver->sponsor;
        if ($receiverUplineLevel1) {
            if ($receiverUplineLevel1->sponsor_id == $sender->id) {
                return true;
            }

            $receiverUplineLevel2 = $receiverUplineLevel1->sponsor;
            if ($receiverUplineLevel2) {
                if ($receiverUplineLevel2->sponsor_id == $sender->id) {
                    return true;
                }

                $receiverUplineLevel3 = $receiverUplineLevel2->sponsor;
                if ($receiverUplineLevel3) {
                    if ($receiverUplineLevel3->sponsor_id == $sender->id) {
                        return true;
                    }

                    $receiverUplineLevel4 = $receiverUplineLevel3->sponsor;
                    if ($receiverUplineLevel4) {
                        if ($receiverUplineLevel4->sponsor_id == $sender->id) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    public function transferWallet(User $authUser, User $userObject)
    {
        return $authUser->isAdmin() || $authUser->id == $userObject->id;
    }
}
