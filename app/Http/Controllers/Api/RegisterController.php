<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FollowUpStatus_Register;
use App\Models\Register;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'register_name' => ['required','max:255'],
            'marketer_id' =>['required'],
            'doctor_name' =>['required','max:255'],
            'register_service' => ['required'],
            'register_information' =>['required','max:255'],
            'campaign_id' => ['required'],
            'ip_address' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        try {
            $register=new Register();
            $register->register_name=$request->register_name;
            $register->doctor_name=$request->doctor_name;
            $register->register_phone=$request->register_phone;
            $register->register_service=$request->register_service;
            $register->registration_source=$request->registration_source;
            $register->campaign_id=$request->campaign_id;
            $register->marketer_id=$request->marketer_id;
            $register->register_ip=$request->register_ip;
            $register->current_status='waiting';
            $register->note=$request->note;
            $register->created_at=Carbon::now();
            $register->save();
            $status=new FollowUpStatus_Register();
            $status->follow_up_status_id=1;
            $register->created_at=Carbon::now();
            $status->save();
            return response()->json([
               'message'=> 'register'.$request->register_name.' successfully created',
                'status'=>200,
                ]);
        }
        catch (\Exception $e){
            return response()->json([
                'message'=> 'failed to create register',
                'status'=>400,
            ]);
        }
    }
}
