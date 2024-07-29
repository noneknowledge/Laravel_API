<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ToDoResource;
use App\Models\ToDo;
use Validator;

class ToDoController extends Controller
{
    //
    public function index(Request $req){

        $user = $req->user();
        return ToDoResource::collection(ToDo::all());
    }

    public function store(Request $req){
        $user = $req->user();

        $rule = [
            'task' => 'required',
            'description' => 'required | min:6',
        ];
        $validator = Validator::make($req->all(),$rule) ;

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fill all fields and follow the rule'
            ],400);
        }

        $validator = Validator::make($req->all(),$rule) ;

        $newToDo = ToDo::create([
            'task' =>  $req->task,
            'taskdescription'=> $req->description,
            'priority' => $req->priority ? $req->priority : 0 ,
            'ownerId' => $user->id,
        ]);

        return new ToDoResource($newToDo);
        
    }

    public function show(Request $req, $todoid){
       
        
        return new ToDoResource(ToDo::find($todoid));
    }

    public function update(Request $req,$todoid){
        return response()->json("update");

    }
}
