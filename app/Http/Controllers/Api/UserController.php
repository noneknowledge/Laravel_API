<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    //
    public function index(Request $req){

        return UserResource::collection(User::all());
    }

    public function store(Request $req){


        return response()->json($req);
    }

    public function show(Request $req, $userid){
       
        return new UserResource(User::find($userid));
    }

    public function update(Request $req,$userid){

        return response()->json("update");
    }

}
