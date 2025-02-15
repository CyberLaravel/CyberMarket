<?php

namespace App\Observers;

use App\Models\User;
use App\Services\UsernameGenerator;

class UserObserver
{
    public function creating(User $user): void
    {
        if (empty($user->username)) {
            $user->username = UsernameGenerator::generateUnique();
        }
    }
}
