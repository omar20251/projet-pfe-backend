<?php

use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Controllers\dummyAPI;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\RecruterController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CandidateController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get("test", [AuthController::class, 'getUsers']);

//-------------------recruiter routes------------------

//recruiter or candidate register  : 
Route::post("register", [RegisterController::class, 'register']);
//afficher recruter  : 
Route::get('/recruiter/{id}',[RecruterController::class, 'AfficherRecruiter']);
//update recruiter : 
Route::put('/update/recruiter/{id}',[RecruterController::class, 'UpdateRecruiter']);
//delete recruiter : 
Route::put('/delete/recruiter/{id}',[RecruterController::class, 'DeleteRecruiter']);




//-------------------candidate routes------------------

//afficher candidate : 
Route::get('/candidate/{id}',[CandidateController::class, 'AfficherCandidate']);
//update candidate : 
Route::put('/update/candidate/{id}',[CandidateController::class, 'UpdateCandidate']);
//delete candidate : 
Route::put('/delete/candidate/{id}',[CandidateController::class, 'DeleteCandidate']);





Route::get("domains", [RecruterController::class, 'domaineList']);
Route::post("login", [AuthController::class, 'login'])->name('login');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("data",[dummyAPI::class,'getData']);
Route::get("list",[DeviceController::class,'list']);
Route::get("login", [AuthController::class, 'login']);

// Email verification routes
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully']);
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification email sent']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

