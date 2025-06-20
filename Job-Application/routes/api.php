<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUp;
use App\Http\Controllers\Controller;

Route::post('/register', [SignUp::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// // // Protected routes (need Sanctum auth)
// // Route::middleware('auth:sanctum')->group(function () {
// //     Route::get('/profile', function (Request $request) {
// //         return $request->user();
// //     });
// // });

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});