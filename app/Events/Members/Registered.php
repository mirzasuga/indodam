<?php

namespace App\Events\Members;

use App\User;
use Illuminate\Queue\SerializesModels;

class Registered
{
    public $newMember;

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $newMember)
    {
        $this->newMember = $newMember;
    }
}
