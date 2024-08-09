<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ToDoController;
use App\Http\Controllers\Api\ProjectController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post("/login", [AuthController::class, 'login']);
Route::post("/register", [AuthController::class, 'register']);
Route::get("/activate/{uid}", [AuthController::class, 'activateUser']);

Route::middleware('auth:sanctum')->group( function(){
    Route::get("/", function(){ return response()->json("hello world from api");});
    Route::apiResource('/user', UserController::Class)->except(['destroy']);
    Route::put("/todo",[ToDoController::class,'update']);
    Route::apiResource('/todo', ToDoController::Class)->except(['destroy','update']);
    Route::apiResource('/project', ProjectController::Class)->except(['destroy','update']);
    
}
);


