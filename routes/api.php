<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Public Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/sent-reset-password-email',[PasswordResetController::class,'forgetPassword']);
Route::post('/reset-password/{token}',[PasswordResetController::class,'resetPassword']);
Route::get('/colleges',[UniversityController::class,'getAllCollege']);
Route::get('/college/{id}',[UniversityController::class,'getCollegeDetails']);
Route::get('/college/course/{id}',[CoursesController::class,'getCourseDetails']);




//login protected routes
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout',[UserController::class,'logout']);
    Route::get('/getProfile',[UserController::class,'getProfile']);
    Route::post('/changepassword',[UserController::class,'changePassword']);
    Route::post('/registerCollege', [UniversityController::class, 'registerCollege']);
});

// admin protected routes
Route::middleware(['auth:sanctum','user-access:admin'])->group(function(){
    
    Route::get('/admin/colleges',[UniversityController::class,'getAllCollegeAdmin']);
    Route::get('/admin/colleges/{id}',[UniversityController::class,'getAllCollegeDetailsAdmin']);
    
});




// manager protected routes
Route::middleware(['auth:sanctum','user-access:manager'])->group(function(){
    
    Route::put('/college/stuff/update', [UniversityController::class, 'updateCollegeDetails']);
    Route::get('/college/stuff/profile',[UniversityController::class,'getMyCollegeDetails']);
    Route::delete('/college/stuff/delete', [UniversityController::class, 'deleteCollege']);
    Route::post('/college/course/register', [CoursesController::class, 'courseRegister']);
    Route::get('/college/stuff/course/details', [CoursesController::class, 'getCourseDetailsForStuff']);
    Route::put('/college/stuff/course/{id}', [CoursesController::class, 'updateCourseDetails']);
    Route::delete('/college/stuff/course/{id}', [CoursesController::class, 'deleteCourse']);
});







Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});