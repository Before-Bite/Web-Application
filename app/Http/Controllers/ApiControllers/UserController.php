<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use App\Mail\ForgotPassword;
use App\Models\UserLanguages;
use App\Models\ProfileSetup;
use App\Models\Follow;
use App\Models\ActivityNotification;
use App\Http\Resources\UserResource;
use App\Http\Resources\FollowersResource;

class UserController extends Controller
{
    public function Registration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            
            
        }

        if($request->password == $request->password_confirmation)
        {
            $accessToken = Str::random(60);

            $User = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'access_token' => Str::random(60),
                'phone_number' => $request->phone_number,
                'isSocialLogin' => 0,
            ]);

            return response()->json(['access_token' => $User->access_token, 'User' => $User]);
        }
        else
        {
            return response()->json(['massage'=>'Password Does Not Match']);
        }

    }

    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'is_social_login' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        if($request->is_social_login == 0)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'is_social_login' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $User = User::with(
                    [
                        'Following',
                        'Follow',
                        'Post' => function($Query)
                        {
                            $Query->select('user_id','dish_picture');
                        },
                        'ProfileSetup',
                        'UserLanguages'
                    ]
                )->where('email',$request->email)->first();
            
            if($User)
            {
                if(Hash::check($request->password, $User->password))
                {
                    return response()->json(['User' => $User]);
                }
                else
                {
                    return response()->json(['message' => 'Password Doesnot Match']);
                }
            }
            else
            {
                return response()->json(['message' => 'Email Not Found']);
            }
        }
        elseif($request->is_social_login == 1)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'is_social_login' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            
            $User = User::with(
                    [
                        'Following',
                        'Follow',
                        'Post' => function($Query)
                        {
                            $Query->select('user_id','dish_picture');
                        },
                        'ProfileSetup',
                        'UserLanguages'
                    ]
                )->where('email',$request->email)->first();

            if($User)
            {
                if($User->email == $request->email && $User->isSocialLogin == $request->is_social_login && $request->password == null)
                {
                    return response()->json(['User' => $User]);
                }
                else
                {
                    return response()->json(['massage'=>'valid Credential']);
                }
            }
            else
            {
                $validator = Validator::make($request->all(), [
                    'email' => 'required|email|unique:users',
                    'is_social_login' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }

                if($request->hasFile('profile_image'))
                {
                    $file = $request->file('profile_image');
                    $image = date('YmdHi').'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('profileImages'), $image);
                }

                $User = User::create([
                    'name' => $request->user_name,
                    'email' => $request->email,
                    'password' => '',
                    'access_token' => Str::random(60),
                    'phone_number' => $request->phone_number,
                    'isSocialLogin' => 1,
                ]);

                $User = User::with(
                        [
                            'Following',
                            'Follow',
                            'Post' => function($Query)
                            {
                                $Query->select('user_id','dish_picture');
                            },
                            'ProfileSetup',
                            'UserLanguages'
                        ]
                    )->where('id',$User->id)->first();

                return response()->json(['User' => $User]);
            }
        }
    }

    public function ForgetPassword(Request $request)
    {
        $User = User::where('email',$request->email)->first();

        if($User)
        {
            $otpNumber = rand(100000,900000);

            $UpdateOtpInUser = User::where('id',$User->id)->update([
                'otp' => 123456,
            ]);

            $details = [
                'email' => $request->email,
                'otpNumber' => 123456,
            ];

            Mail::to($request->email)->send(new ForgotPassword($details));

            return response()->json(['message' => 'OTP sent successfully Please Check Your Email.']);
        }
        else
        {
            return response()->json(['message' => 'Email Not Found.']);
        }
    }

    public function OtpVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $User = User::where('email',$request->email)->first();

        if($User)
        {
            if($User->otp == $request->otp)
            {
                return response()->json(['massage'=>'OTP Verified Successfully']);
            }
            else
            {
                return response()->json(['massage'=>'OTP is Worng']);
            }
        }
        else
        {
            return response()->json(['massage'=>'Email is not valid']);
        }
    }

    public function ResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'New_password' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $User = User::where('email', $request->email)->first();
        if($User)
        {
            if($User->otp == $request->otp)
            {
                $User = User::where('id',$User->id)->update([
                    'password' => Hash::make($request->New_password),
                ]);

                return response()->json(['massage'=>'Password Reset Successfully']);
            }
            else
            {
                return response()->json(['massage'=>'OTP is Worng']);
            }
        }
        else
        {
            return response()->json(['massage'=>'Email is not valid']);
        }
        dd($User);
    }

    public function UpdatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if($request->new_password === $request->confirm_new_password)
        {
            $User = User::where('email',$request->email)->first();

            if($User)
            {
                if(Hash::check($request->old_password, $User->password))
                {
                    $User = User::where('id',$User->id)->update([
                        'password' => Hash::make($request->new_password),
                    ]);
    
                    return response()->json(['message'=>'Password Updated Successfully']);
                }
                else
                {
                    return response()->json(['message'=>'Your Old Password is not Currect!']);
                }
            }
            else
            {
                return response()->json(['massage'=>'Email is not valid']);
            }
        }
        else
        {
            return response()->json(['massage'=>'Your new password and confirm password doesnot match']);
        }
    }

    public function ProfileSetup(Request $request)
    {
        $User = User::where('id',$request->user_id)->first();
        if($User)
        { 
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'lat' => 'required',
                'long' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'clain_for_fame' => 'required',
                'profile_image' => 'required',
                'user_name' => 'required',
                'languages' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            if($request->hasFile('profile_image'))
            {
                $file = $request->file('profile_image');
                $image = date('YmdHi').'.'.$file->getClientOriginalExtension();
                $file->move(public_path('profileImages'), $image);
            }

            $ProfileSetup = ProfileSetup::create([
                'user_id' => $request->user_id,
                'image' => 'profileImages/'.$image,
                'lat' => $request->lat,
                'long' => $request->long,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'clain_for_fame' => $request->clain_for_fame,
            ]);

            $User = User::where('id',$request->user_id)->update([
                'name' => $request->user_name,
            ]);

            foreach($request->languages as $item)
            {
                $UserLanguages = UserLanguages::create([
                    'user_id' => $request->user_id,
                    'languages' => $item,
                ]);
            }

            return response()->json(['massage'=>'Profile Setup Successfully']);
        }
        else
        {
            return response()->json(['massage'=>'Email is not valid']);
        }

    }

    public function Follow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'friend_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user_id = User::where('id',$request->user_id)->first();

        $friend_id = User::where('id',$request->friend_id)->first();

        if($user_id && $friend_id)
        {
            $CheckFollowOrNot = Follow::where('user_id',$request->user_id)->where('friend_id',$request->friend_id)->first();

            if($CheckFollowOrNot)
            {
                $Follow = Follow::findOrFail($CheckFollowOrNot->id);
                $ActivityNotification = ActivityNotification::where('user_id',$request->user_id)->where('follow','follow')->first();
                $ActivityNotification->delete();
                $Follow->delete();
                return response()->json(['message'=>'You UnFollow Your Friend Successfully Done']);
            }
            else
            {
                $Follow = Follow::create([
                    'user_id' => $request->user_id,
                    'friend_id' => $request->friend_id,
                    'status' => $request->status,
                ]);

                $ActivityNotification = ActivityNotification::create([
                    'user_id' => $request->user_id,
                    'post_id' => NULL,
                    'friend_id' => $request->friend_id,
                    'follow' => 'follow',
                    'status' => 'is following you',
                ]);
            }

            return response()->json(['message'=>'Follow Successfully']);
        }
        else
        {
            return response()->json(['massage'=>'User Not Found!']);
        }
    }
    
    
    public function MyFollowers(Request $request){
        
        $follower = Follow::select('user_id')->where('friend_id',$request->id)->get();
        $user = User::with('ProfileSetup')->whereIn('id',$follower)->get();
         return FollowersResource::collection($user); 
    }

}

// mSWDWNcGnrNE@F7
// us4s?$H=8.z6





















