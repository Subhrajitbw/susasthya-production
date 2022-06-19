<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\DoctorController;
use App\Http\Controllers\KYDController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\Auth\DoctorRegisterController;
/*
|--------------------------login------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::controller(App\Http\Controllers\Auth\RegisterController::class)->group(function(){
//     Route::post('register', 'register');
//     Route::post('login', 'login');
// });
 Route::post('register',[RegisterController::class, 'validator']);
 //Route::post('register',[RegisterController::class, 'create']);

 Route::post('login', [LoginController::class, 'login']);

 Route::get('blogs', function () {
    $posts = TCG\Voyager\Models\Post::all();
    return response($posts, 201);
});

Route::get('blogs/{post}', function ($post) {
    
    $posts = TCG\Voyager\Models\Post::where('slug', $post)->firstOrFail();
    return response($posts, 201);
});

Route::get('categories', function() {
    $cat = TCG\Voyager\Models\Category::all();
    return response($cat, 201);
});

Route::get('services', function() {
    $cat = \App\Service::all();
    return response($cat, 201);
});

Route::post('know-your-disease', [KYDController::class, 'create']);

Route::get('appointments/{id}', function($id){
    $appointments = \App\Appointment::where('user_id', '=', $id)->get();
    return response($appointments, 201);
});

Route::get('appointments/doctor/{id}', function($id){
    $appointments = \App\Appointment::where('doctor_id', '=', $id)->get();
    return response($appointments, 201);
});

Route::get('doctor/{id}', function($id){
    $doctor = \App\Doctor::where('id', $id)->firstOrFail();
    return response($doctor, 201);
});

Route::get('doctor', function(){
    $doctor = \App\Doctor::all();
    return response($doctor, 201);
});

Route::post('user/update/{patient_id}', [LoginController::class, 'update']);

Route::post('reset-password/{patient_id}', [LoginController::class, 'changePassword']);

Route::get('locations/{id}', function($id){
    $loc=\App\Location::where('doctor_id', $id)->get();
    return response($loc, 201);
});

Route::post("appointment/create", [AppointmentsController::class, 'create']);
// Route::middleware('auth:sanctum')->group( function () {
//     Route::resource('products', ProductController::class);
// });

Route::get("search/{term}", function($term){
    $result = App\Doctor::select("*")->where("name", 'LIKE',  $term.'%')
                                     ->orWhere("department", 'LIKE',  $term.'%')->get();
    return response($result, 201);                                  
                                         
});


Route::post("doctor/register", [DoctorRegisterController::class, 'validator']);
Route::post('doctor/login', [DoctorController::class, 'login']);

Route::post('doctor/reset-password/{patient_id}', [DoctorController::class, 'changePassword']);

Route::post('appointments/accept/{id}', function($id){
    $appointments = \App\Appointment::where('appointment_id', '=',  $id)->first();
    $appointments->status = "option1";
    $appointments->save();
    return response($appointments, 201);
});

Route::post('appointments/cancel/{id}', function($id){
    $appointments = \App\Appointment::where('appointment_id', '=', $id)->first();
    $appointments->status = "option3";
    $appointments->save();
    return response($appointments, 201);
});