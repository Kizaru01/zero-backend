<?php

namespace App\Policies;

use App\Models\Ride;
use App\Models\User;

class RidePolicy
{
    public function view(User $user, Ride $ride): bool
    {
        return $user->id === $ride->user_id;
    }

    public function update(User $user, Ride $ride): bool
    {
        return $user->id === $ride->user_id;
    }

    public function delete(User $user, Ride $ride): bool
    {
        return $user->id === $ride->user_id;
    }
}
