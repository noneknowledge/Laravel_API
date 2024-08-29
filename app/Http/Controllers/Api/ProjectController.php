<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\UserProject;
use App\Models\UserFriend;
use App\Models\Container;
use Validator;

class ProjectController extends Controller
{
    public function index(Request $req){
        $user = $req->user();
        $data = Project::with('leader:id,fullname')->whereHas('members', function( $query) use ($user){
            $query->where('userid',$user->id) ;
        })->get();
        // return response()->json($data);
        return ProjectResource::collection($data);
    }
    public function show(Request $req, $id){
        $user = $req->user();
        $id = intval($id);
        $isMember = Project::where('id',$id)->whereHas('members', function($query) use($user){
            $query->where('userid',$user->id);
        })->first();
        if ($isMember === null){
            return response()->json("You're not allowed to see this project!");
        }
        $projectMember = [];
        $members = UserProject::with('member')->where('projectid',$id)->get();
        foreach($members as $member){
            $pushItems  = $member->member;
            $pushItems->role = $member->role;
            array_push($projectMember,$pushItems);
        }
        
        $data = Container::where("projectid",$id)->with("tasks")->get();

        return response()->json([
            'msg' => "Get request $id",
            'data' =>$data,
            'project' => $isMember,
            'members' => $projectMember
        ]);
    }
    public function store(Request $req){

        $user = $req->user();
        $rule = [
            'title' => 'required',
        ];
        $validator = Validator::make($req->all(),$rule) ;

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fill all fields and follow the rule'
            ],400);
        }

        $newProject = Project::create([
            'title'=> $req->title,
            'thumbnail' => $req->thumbnail, 
            'leaderId' => $user->id]);

        UserProject::create([
            'userid' => $user->id,
            'role' => 'admin',
            'projectid' => $newProject->id
        ]);

        $data = Project::orderBy('id',"desc")->with('leader:id,fullname')->whereHas('members', function( $query) use ($user){
            $query->where('userid',$user->id);
        })->first();

       

        return response()->json([
            'msg' => "you did it",
            'data' => $data
        ]);
    }

    public function setting(Request $req,$pid){
        try{
            $user = $req->user();
            if (is_numeric($pid) && (int)$pid == $pid) {
                $project = Project::with('leader:id,fullname')->findOrFail($pid);  
                $myFriends = [];
                $projectMember = [];
                $friends = UserFriend::with('user1')->with('user2')->where('user2id',$user->id)
                ->orWhere('user1id',$user->id)->where('status1','follow')->where('status2','follow')->select('user1id','user2id')->get();
                $members = UserProject::with('member')->where('projectid',$pid)->get();
                foreach($members as $member){
                    $pushItems = $member->member;
                    $pushItems->role = $member->role;
                    array_push($projectMember,$pushItems);
                } 
                foreach($friends as $friend){
                    if($friend->user1id === (int)$user->id){
                        array_push($myFriends,$friend->user2);
                    }
                    else{
                        array_push($myFriends,$friend->user1);
                    }
                }
                return response()->json([
                    'project' => $project,
                    'user' => $user,
                    'members' => $projectMember,
                    'friends' => $myFriends,
                ]);
            } 
            else 
            {
                throw new Error("project not found");
            }
        }
        catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
            ],400);
        }
        
        return response()->json("setting project $pid");
    }

    public function addMember(Request $req,$pid){
        try{
            $user = $req->user();
            $isMember = Project::where('id',$pid)->whereHas('members', function($query) use($user){
                $query->where('userid',$user->id);
            })->first();
            if ($isMember === null){
                return response()->json("You're not allowed to see this project!");
            }
            foreach($req->members as $member){
                UserProject::create([
                    'userid' => $member,
                    'projectid' => $pid
                ]);
            }
            return response()->json([
                'msg' => 'Add success',
                'total'=> count($req->members)
            ]);
        }
        catch (\Exception $e){
            return response()->json([
                'msg' => $e->getMessage(),
            ],400);
        }
    }

    public function destroy(Request $req,$pid){
        try{
            $user = $req->user();
            $project = Project::find($pid);
            if ($project->leaderid === $user->id)
            {
                $column = Container::where('projectid',$pid)->first();
                $column->delete();
                // $project->delete();
                return response()->json([
                    'msg' => 'Deleted',
                    'project' => $project
                ]);
            }
            else
            {
                return response()->json([
                    'msg' => 'You are not allow to do this'
                ]);
            }
        }
        catch (\Exception $e){
            return response()->json([
                'msg' => $e->getMessage()
            ],400);
        }
    }
}
