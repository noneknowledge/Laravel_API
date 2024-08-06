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
        $data = $req->all();

        $rule = [
            'task' => 'required',
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
            'priority' => $req->priority ? $req->priority : 4 ,
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
