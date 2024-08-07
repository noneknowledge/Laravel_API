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
        $todos = ToDo::where('ownerId',2)->get();
        return ToDoResource::collection($todos);
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

    public function update(Request $req){

        $var = 0;
        $data = $req->all();
        foreach($data as $task){
            if($task['action']){
                $item = ToDo::find($task['id']);
                if($task['action'] === 'update'){
                   
                    $item->task = $task['task'];
                    $item->status = $task['status'];
                    $item->priority = $task['priority'];
                    $item->save();
                  
                }
                else{

                    ToDO::destroy($id);
                   
                    return response()->json($item);
                }
                
            }
        }

        return response()->json($var);

    }
}
