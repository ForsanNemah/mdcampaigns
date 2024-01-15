<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Coordinator;
use App\Models\Register;
use Illuminate\Auth\Access\Response;

class RegisterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Account $account): bool
    {
    return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Account $account, Register $register): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Account $account): bool
    {
     return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Account $account, Register $register): bool
    {

        if (isCoordinator()) {
            $coordinator= Coordinator::where('id',$account->accountable_id)->first();
            return $coordinator->clinic_id === $register->campaign->clinic_id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Account $account, Register $register): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $register->campaign->clinic_id;
        }
        if (isCoordinator()) {
            return coordinatorClinic() === $register->campaign->clinic_id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Account $account, Register $register): bool
    {
        return isAdmin() || isCoordinator() || isClinic();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Account $account, Register $register): bool
    {

        if (isClinic()) {
            return $account->accountable_id === $register->campaign->clinic_id;
        }
        return isAdmin();
    }

    public function  forceDeleteAny(Account $account): bool
    {

        return isAdmin() || isClinic();
    }
    public function  restoreAny(Account $account): bool
    {
        return isAdmin()  || isClinic();
    }
}
