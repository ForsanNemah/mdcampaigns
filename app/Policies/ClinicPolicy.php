<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Clinic;
use Illuminate\Auth\Access\Response;

class ClinicPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return isAdmin()|| isCustomer();

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Account $account, Clinic $clinic): bool
    {
         if(isAdmin() )
        {
            return true;
        }
        if (isCustomer()) {
            return $account->accountable_id === $clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Account $account): bool
    {
        return isAdmin()|| isCustomer();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Account $account, Clinic $clinic): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isCustomer()) {
            return $account->accountable_id === $clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Account $account, Clinic $clinic): bool
    {

        if(isAdmin() )
        {
            return true;
        }
        if (isCustomer()) {
            return $account->accountable_id === $clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Account $account, Clinic $clinic): bool
    {

        if(isAdmin() )
        {
            return true;
        }
        if (isCustomer()) {
            return $account->accountable_id === $clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Account $account, Clinic $clinic): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isCustomer()) {
            return $account->accountable_id === $clinic->customer_id;
        }
        return false;
    }
}
