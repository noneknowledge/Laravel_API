<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    //
    public function index(Request $req){

    }
    public function store(Request $req){

        return response()->json([
            'msg' => "Post new task",
            'data' => $req->all()
        ]);
    }


}
