<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\UserProject;
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
        
        $data = Container::where("projectid",$id)->with("tasks")->get();


        return response()->json([
            'msg' => "Get request $id",
            'data' =>$data,
            'project' => $isMember
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
   
}
