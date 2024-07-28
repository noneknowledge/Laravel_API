<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    // echo csrf_token();
    
    return view("welcome");
});


