<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskMember;
use App\Models\Project;
use App\Models\Container;
use App\Models\UserProject;

class TaskController extends Controller
{
    //
    public function index(Request $req){

    }
    public function store(Request $req,$pid){
        $user = $req->user();
        $isMember = UserProject::where('projectid',$pid)->where('userid',$user->id)
        ->first();
        if ($isMember === null){
            return response()->json("You're not allowed to see this project!");
        }
    
        if($isMember->role === "admin" || $isMember->role === 'editor'){
            $newTask = Task::create([
                'title' => $req->task,
                'description' => $req->description?$req->description:null,
                'tag' => $req->tag,
                'containerid' => $req->containerid
            ]);
            foreach (explode(',',$req->members) as $member){
                TaskMember::create([
                    'taskid' => $newTask->id,
                    'userid'=> $member
                ]);
            }
            return response()->json([
                'formData' => $req->all(),
                'newTask' =>$newTask
            ]);
        }
        else{
            return response()->json([
                'msg' => "You are not allowed to perform this action"
            ],400);
        }


        return response()->json([
            'msg' => "Post new task",
            'data' => $req->all()
        ]);
    }


}
