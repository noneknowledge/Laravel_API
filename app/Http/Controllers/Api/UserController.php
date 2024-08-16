<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserFriend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use DB;

class UserController extends Controller
{
    //
    public function index(Request $req){

        return UserResource::collection(User::all());
    }


    //add friend
    public function store(Request $req){
        $user = $req->user();
        $towardId = $req->userid;
        if($user->id === $towardId){
            return response()->json([
                'msg' => "cant add your self as a friend"
            ],400);
        }
        $exist = UserFriend::where('user1id',$user->id)->where('user2id',$towardId)->first();
        if($exist){
            if($exist->status1){
                $exist->status1 = NULL;
                $exist->save();
                if($exist->status1 === NULL)
                {
                    DB::select("CALL DELETE_FRIEND($user->id,$towardId)");
                }
                return response()->json([
                    'msg' => 'Remove friend success'
                ]);
            }
            else{
                $exist->status1 = 'follow';
                $exist->save();
                return response()->json([
                    'msg' => 'Add friend success'
                ]);
            }
           
        }
        $exist = UserFriend::where('user1id',$towardId)->where('user2id',$user->id)->first();
        if($exist){
            if($exist->status2){
                $exist->status2 = NULL;
                $exist->save();
                if($exist->status2 === NULL)
                {
                    DB::select("CALL DELETE_FRIEND($user->id,$towardId)");
                }
                return response()->json([
                    'msg' => 'Remove friend success'
                ]);
            }
            else{
                $exist->status2 = 'follow';
                $exist->save();
                return response()->json([
                    'msg' => 'Add friend success'
                ]);
            }
        }
        $newFriend = UserFriend::create([
            'user1id' => $user->id,
            'user2id' => $towardId,
            'status1' => 'follow'
        ]);
        return response()->json([
            'msg'=> 'Add friend request sent'
        ],201);
    }

    //show profile
    public function show(Request $req, $uid){
        try{
            $user = User::find($uid);
            $userResource = null;
            if($user){
                $userResource = new UserResource($user);
            }
            $myFriends = [];
           
            $friends = UserFriend::with('user1')->with('user2')->where('user2id',$uid)
            ->orWhere('user1id',$user->id)->where('status1','follow')->where('status2','follow')->select('user1id','user2id')->get();
            foreach($friends as $friend){
                if($friend->user1id === (int)$uid){
                    array_push($myFriends,$friend->user2);
                }
                else{
                    array_push($myFriends,$friend->user1);
                }
            
            }


            return [
                'user'=> $userResource,
                'friends' => $myFriends,
                'project' => 'my project'
            ];
           
        }
        catch(\Exception $error){
            return response()->json(['message'=>$error->getMessage()],500);
        }
        
    }

    public function update(Request $req,$userid){

        return response()->json("update");
    }

}
