<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Validator;

class ProjectController extends Controller
{
    public function index(Request $req){
        return response()->json("This is get request");
    }
    public function show(Request $req, $id){

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

        return response()->json([
            'msg' => "you did it",
            'data' => $newProject
        ]);
    }
   
}
