<?php

namespace App\Policies;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ChirpPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Chirp $chirp
     * @return bool
     */
    public function update(User $user, Chirp $chirp)
    {
        return $chirp->user()->is($user);
    }

    public function delete(User $user, Chirp $chirp)
    {
        return $this->update($user,$chirp);
    }
}
