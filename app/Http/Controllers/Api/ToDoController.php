<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ToDoResource;
use App\Models\ToDo;

class ToDoController extends Controller
{
    //
    public function index(Request $req){

        return ToDoResource::collection(ToDo::all());
    }

    public function store(Request $req){


    }

    public function show(Request $req, $todoid){
       
        return new ToDoResource(ToDo::find($todoid));
    }

    public function update(Request $req,$todoid){
        return response()->json("update");

    }
}
