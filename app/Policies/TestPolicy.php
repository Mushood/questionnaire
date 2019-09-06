<?php

namespace App\Policies;

use App\Models\Test;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
{
    use HandlesAuthorization;

    public function show(User $user = null, Test $test)
    {
        $hasAccess = false;
        /**
         * No user attached to this test
         */
        if ($test->user_id === null) {
            $hasAccess = true;
        }

        /**
         * User logged in and test belongs to user
         */
        if ($user !== null && $test->user_id !== null && $user->id === $test->user_id) {
            $hasAccess = true;
        }

        return $hasAccess;
    }
}
