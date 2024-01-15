<?php

use App\Models\Account;

if (! function_exists('isAdmin')) {
    function isAdmin():bool
    {
      return  (auth()->user()->accountable_type=='user')?true:false;
    }
}
if (! function_exists('isCustomer')) {
    function isCustomer():bool
    {
        return  (auth()->user()->accountable_type=='customer')?true:false;
    }
}
if (! function_exists('isClinic')) {
    function isClinic():bool
    {
        return (auth()->user()->accountable_type=='clinic')?true:false;
    }
}if (! function_exists('isCoordinator')) {
    function isCoordinator():bool
    {
        return   (auth()->user()->accountable_type=='coordinator')?true:false;
    }
}if (! function_exists('isMarketer')) {
    function isMarketer():bool
    {
        return   (auth()->user()->accountable_type=='marketer')?true:false;
    }
}
if (! function_exists('toggleStatus')) {
    function toggleStatus($account_id,$status)
    {
       $account=Account::find($account_id);
       $account->status=$status;
       $account->save();
    }
}


if (! function_exists('coordinatorClinic')) {
    function coordinatorClinic():int
    {
        $coordinator= \App\Models\Coordinator::find(auth()->user()->accountable_id)->first();

        return $coordinator->clinic_id ;
    }
}

if (! function_exists('marketerClinic')) {
    function marketerClinic():int
    {
        $marketer= \App\Models\Marketer::find(auth()->user()->accountable_id)->first();

        return $marketer->clinic_id ;
    }
}
