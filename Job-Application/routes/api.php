<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUp;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApplicationController;


Route::post('/register', [SignUp::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);


Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/jobs/{jobId}/apply', [ApplicationController::class, 'apply']);

});

Route::middleware('auth:api')->group(function () {
   
    Route::middleware('role:applicant')->group(function () {
        Route::get('/applications', [BrowserController::class, 'getApplications']);
    });
    });
Route::middleware('auth:api')->group(function () {
   Route::middleware('role:company')->group(function () {
        Route::post('/jobs', [JobController::class, 'createJob']);
        Route::put('/jobs/{id}', [JobController::class, 'updateJob']);
        Route::delete('/jobs/{id}', [JobController::class, 'deleteJob']);
    });
});



