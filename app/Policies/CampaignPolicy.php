<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Campaign;
use App\Models\Coordinator;
use App\Models\Marketer;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Builder;

class CampaignPolicy
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
    public function view(Account $account, Campaign $campaign): bool
    {
        if(isAdmin() )
        {
            return true;
        }
        if (isClinic()) {
            return $account->accountable_id === $campaign->clinic_id;
        }
        if (isCustomer()) {
            return $account->accountable_id === $campaign->clinic->customer_id;
        }
        if(isMarketer()){
            $marketer= Marketer::where('id',$account->accountable_id)->first();
            return $marketer->clinic_id === $campaign->clinic_id;
        }
        if(isCoordinator()){
            $coordinator= Coordinator::where('id',$account->accountable_id)->first();
            return $coordinator->clinic_id === $campaign->clinic_id;
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
    public function update(Account $account, Campaign $campaign): bool
    {
        return isAdmin()|| isCustomer() || isClinic();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Account $account, Campaign $campaign): bool
    {
        return isAdmin()|| isCustomer() || isClinic();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Account $account, Campaign $campaign): bool
    {
        return isAdmin()|| isCustomer() || isClinic();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Account $account, Campaign $campaign): bool
    {
        return isAdmin()|| isCustomer() || isClinic();
    }
}
