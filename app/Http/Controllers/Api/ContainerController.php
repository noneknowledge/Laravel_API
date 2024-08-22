<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Container;
use App\Models\UserProject;


class ContainerController extends Controller
{
    //
    public function store (Request $req,$pid){
        $user = $req->user();
        $isMember = UserProject::where('projectid',$pid)->where('userid',$user->id)
        ->first();
        if ($isMember === null){
            return response()->json("You're not allowed to see this project!");
        }
        if($isMember->role === "admin" || $isMember->role === 'editor'){
            $newColumn = Container::create(['projectid' => $pid, 'title'=>'New column']);
            return response()->json([
                'newColumn' => $newColumn,
                'msg' =>"Created"
            ],201);
        }
        else{
            return response()->json([
                'msg' => 'You are not allowed to do this'
            ]);
        }

    }
}
