<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Account $user): bool
    {
 return (auth()->user()->accountable_type=='user')?true:false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Account $user, Customer $customer): bool
    {
 return (auth()->user()->accountable_type=='user')?true:false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Account $user): bool
    {
 return (auth()->user()->accountable_type=='user')?true:false;    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Account $user, Customer $customer): bool
    {
 return (auth()->user()->accountable_type=='user')?true:false;    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Account $user, Customer $customer): bool
    {
 return (auth()->user()->accountable_type=='user')?true:false;    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Account $user, Customer $customer): bool
    {
 return (auth()->user()->accountable_type=='user')?true:false;    }

    /**
     * Determine whether the user can permanently delete the model.
     */

    public function forceDelete(Account $user, Customer $customer): bool
    {
 return (auth()->user()->accountable_type=='user')?true:false;    }
}
