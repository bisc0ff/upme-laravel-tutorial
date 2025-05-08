<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    //for both soft-del and perma delete
    public function delete(User $user)
    {
        return $user->is_admin;
    }

    public function update(User $user)
    {
        return $user->is_admin;
    }
}
