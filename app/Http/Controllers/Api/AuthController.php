<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Auth\Events\Verified;



class AuthController extends Controller
{
    


    public function register(Request $request){




    $user=User::create([


        'username'=>$request->username,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'password'=>Hash::make($request->password),
        
    ]);


    //$token = $user->createToken('api_token')->plainTextToken;

   

      // Send verification email
      $user->sendEmailVerificationNotification();


    return response()->json([


        "message"=> __('user_created'),

        "user"=>$user,

       // "token"=>$token


    ],201);






    }



    public function verify(Request $request, $id, $hash)
{
    $user = User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
       // return response()->json(['message' => 'Invalid verification link'], 403);
       return view('emails.verified-error');
    }

    if ($user->hasVerifiedEmail()) {
       // return response()->json(['message' => 'Email already verified']);
       return view('emails.already-verified');
    }

    $user->markEmailAsVerified();
    event(new Verified($user));

   // return response()->json(['message' => 'Email verified successfully. You can now log in.']);

   return view('emails.verified-success');


}






public function login(Request $request){



    $validator=Validator::make($request->all(),[


        "username"=>["required_without:email","string"],
        "email"=>["required_without:username","string"],
        "password"=>["required","string"]



    ]);


    if ($validator->fails()) {


        return response()->json([



            
            "status"=>"error",
            "message"=>"validation failed",
            "errors"=>$validator->errors()





        ],422);


    }


    $user=null;


    if (!empty($request->username)) {
       
        $user=User::where("username",$request->username)->first();
    }


    else{

        $user=User::where("email",$request->email)->first();

    }

    if ($user) {
     


        if (Hash::check($request->password, $user->password)) {


           
            // check verified user

            if (! $user->hasVerifiedEmail()) {

                return response()->json(['message' => 'Please verify your email before logging in'], 403);
            }


            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'message'=>"login to the system is successfully",
                'user' => $user,
                'token' => $token
            ], 200);
            
        }

        else{


            return response()->json([


                "message"=>"password is incorrect"
          
          
          
                  ],401);


        }



    }

    else{

        return response()->json([


      "message"=>"username or email is not in the system"



        ],401);


    }



}


public function logout(Request $request)
{
    $token = $request->attributes->get('accessToken');

    if ($token) {
        $token->delete();
        return response()->json(['message' => 'Logged out from the current device'], 200);
    }

    return response()->json(['message' => 'No token found or already logged out'], 400);
}


public function logoutAll(Request $request)
{
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'Logged out from all devices'], 200);
}








}
