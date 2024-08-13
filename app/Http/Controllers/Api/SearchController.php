<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class SearchController extends Controller
{
    public function searchPrompt(Request $req, $keyword){
        $data = User::select('id','fullname', 'email')->where(function($query) use($keyword){
           $query->where('fullname','LIKE','%'.$keyword.'%')
           ->orWhere('email','LIKE','%'.$keyword.'%'); 
        })->get();
        return response()->json([
            'msg' => "search prompt",
            'data' => $data 
        ]);
    }
    
    public function searchUser(Request $req, $keyword){
        $data = User::select('id','fullname', 'email')->where(function($query) use($keyword){
            $query->where('fullname','LIKE','%'.$keyword.'%')
            ->orWhere('email','LIKE','%'.$keyword.'%'); 
         })->get();
         return response()->json([
             'msg' => "search result",
             'data' => $data 
         ]);
    }
}
