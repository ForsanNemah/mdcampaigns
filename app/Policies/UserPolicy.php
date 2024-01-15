<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Account $user, User $model): bool
    {

     return isAdmin();

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Account $user): bool
    {
      return isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Account $user, User $model): bool
    {
 return isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Account $user, User $model): bool
    {
      return isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Account $user, User $model): bool
    {
      return isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Account $user, User $model): bool
    {
      return isAdmin();
    }
}
