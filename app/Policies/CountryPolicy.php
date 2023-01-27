<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return true;
    }


    public function view(User $user, $model)
    {
        return true;
    }


    public function create(User $user)
    {
        return true;
    }


    public function update(User $user, $model)
    {
        return true;
    }


    public function replicate(User $user, $model)
    {
        return false;
    }


    public function delete(User $user, $model)
    {
        return true;
    }


    public function forceDelete(User $user, $model)
    {
        return false;
    }


    public function restore(User $user, $model)
    {
        return false;
    }


    public function runAction(User $user)
    {
        return true;
    }


    public function runDestructiveAction(User $user)
    {
        return true;
    }
}
