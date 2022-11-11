<?php

namespace App\Http\Controllers;

use App\Models\AccountActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function changeuserpassword(Request $request){
        $authuser = Auth::user();
        $user = DB::table('users')->where('id',$authuser->id)->get();
        $currenthashedpassword = $user[0]->password;
        $istrue= Hash::check($request->currentpassword, $currenthashedpassword);
        if($istrue == false){
            return ['status'=>3];
        }else{
            if($request->newpassword!=$request->newpasswordconfirm){
                return ['status'=>2];
            }
            else{
                $newpass = Hash::make($request->newpassword);
                $user = User::find($authuser->id);
                $user->password = $newpass;
                $user->save();
                $activity = new AccountActivity();
                $activity->systime = date('Y-m-d H:i:s');
                $activity->type=3;
                $activity->user()->associate($user);
                $activity->save();
                return ['status'=>1];
            }
        }
        
    }
}
