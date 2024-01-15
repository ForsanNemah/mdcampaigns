<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Coordinator;
use Illuminate\Auth\Access\Response;

class CoordinatorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return isAdmin()|| isCustomer() || isClinic();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Account $account, Coordinator $coordinator): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $coordinator->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $coordinator->clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Account $account): bool
    {
        return isAdmin()|| isCustomer() || isClinic();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Account $account, Coordinator $coordinator): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $coordinator->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $coordinator->clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Account $account, Coordinator $coordinator): bool
    {

        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $coordinator->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $coordinator->clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Account $account, Coordinator $coordinator): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $coordinator->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $coordinator->clinic->customer_id;
        }
        return false;    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Account $account, Coordinator $coordinator): bool
    {

        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $coordinator->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $coordinator->clinic->customer_id;
        }
        return false;
    }
}
