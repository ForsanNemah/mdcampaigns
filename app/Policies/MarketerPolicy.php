<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Marketer;
use Illuminate\Auth\Access\Response;

class MarketerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Account $account): bool
    {
        return isAdmin()|| isCustomer() || isClinic();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Account $account, Marketer $marketer): bool
    {

        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $marketer->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $marketer->clinic->customer_id;
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
    public function update(Account $account, Marketer $marketer): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $marketer->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $marketer->clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Account $account, Marketer $marketer): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $marketer->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $marketer->clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Account $account, Marketer $marketer): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $marketer->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $marketer->clinic->customer_id;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Account $account, Marketer $marketer): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $marketer->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $marketer->clinic->customer_id;
        }
        return false;
    }
}
