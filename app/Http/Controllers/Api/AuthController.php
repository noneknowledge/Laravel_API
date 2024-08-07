<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;
use Mail;
use App\Mail\WelcomeMail;
use App\Jobs\Sendmail;


class AuthController extends Controller
{
    //
    public function login(Request $req){

        
        if( $req->username && $req->password)
        {
            $credentials = ['username' => $req->username,'password' => $req->password, 'active'=>1];
            try{
                $auth = Auth::attempt($credentials);
                if($auth){
                    $token = Auth::user()->createToken(name:'authToken',expiresAt:now()->addMinutes(60))->plainTextToken;
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
                }
                else{
                    return response()->json([
                        'message' => "Invalid user",
                    ],400);
                }
                

            }
            catch (\Exception $e){
                
                return response()->json([
                    'message' => $e->getMessage(),
                ],500);
            }
         
            
        }
        else{
            return response()->json([
                'username' => $req->username,
                'password' => $req->password,
                'message' => 'Please fill '
            ]);
        }
    
    }

    public function register(Request $req){

        $rule = [
            'username' => 'required | unique:users',
            'password' => 'required | min:6',
            'email' => 'required | email',
            'fullname' => 'required'
        ];
        $validator = Validator::make($req->all(),$rule) ;

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fill all fields and follow the rule'
            ],400);
        }
        try{
            $user = User::create([
                'username' => $req->username,
                'password' => $req->password,
                'fullname' => $req->fullname,
                'email' => $req->email,
                'active' => 0
            ]);

            $this->sendActivateEmail($user);
            // $mailQueue = new SendMail($user);
            // dispatch($mailQueue)->delay(now()->addSeconds(10));

            return response()->json([
                'message' => 'Register success!',
            ],201);
        }
        catch (\Exception $e){
          
            return response()->json([
                'message' => $e->getMessage()
            ],400);
        }
        
        

      
       
        
       
    }

    public function sendActivateEmail(User $user){
        $mailQueue = new SendMail($user);
        dispatch($mailQueue)->delay(now()->addSeconds(10));
    }

    public function activateUser(Request $req,string $uid){
        try{
            $exist = User::find($uid);
            // return response()->json($exist);
            if ($exist){
                $exist->active = 1;
                return response()->json($exist);
                $exist->save();

                return response()->json("Activated user: $user->fullname");
            }
            else{
                return response()->json("no user");
            }

            

        }
        catch (\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ],400);
        }
        
    
    }

}
