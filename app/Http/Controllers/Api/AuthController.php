<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use Validator;

class AuthController extends Controller
{
    //
    public function login(Request $req){

        if( $req->username && $req->password)
        {
            $credentials = ['username' => $req->username,'password' => $req->password];
            try{
                $auth = Auth::attempt($credentials);
    
                $token = Auth::user()->createToken('authToken')->plainTextToken;
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
    
                ]);

            }
            catch (\Exception $e){
                
                return response()->json([
                    'message' => $e->getMessage(),
                ],500);
            }
         
            
        }
        else{
            return response()->json("please fill the username and password");
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
        // return response()->json("validate success");
        $user = User::create([
            'username' => $req->username,
            'password' => $req->password,
            'fullname' => $req->fullname,
            'email' => $req->email,
            'active' => 0
        ]);

        return response()->json([
            'message' => 'Register success!',
        ],201);
       
        
       
    }
}
