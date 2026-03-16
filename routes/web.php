<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RedirectController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:sanctum')->group(function(){

Route::get('/user', function(Request $request){
    return $request->user();
});

Route::put('/user', [UserController::class,'update']);

Route::delete('/user', [UserController::class,'destroy']);

});

Route::get('/{short_code}', [RedirectController::class,'redirect']);
