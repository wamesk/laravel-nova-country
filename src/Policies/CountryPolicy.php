<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user): bool
    {
        return true;
    }


    public function view(User $user, $model): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        return true;
    }


    public function update(User $user, $model): bool
    {
        return true;
    }


    public function replicate(User $user, $model): bool
    {
        return false;
    }


    public function delete(User $user, $model): bool
    {
        return true;
    }


    public function forceDelete(User $user, $model): bool
    {
        return false;
    }


    public function restore(User $user, $model): bool
    {
        return false;
    }


    public function runAction(User $user): bool
    {
        return true;
    }


    public function runDestructiveAction(User $user): bool
    {
        return true;
    }
}
