<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiControllers\UserController;
use App\Models\User;
use App\Http\Controllers\ApiControllers\RestaurentController;
use App\Models\Restaurent;

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


Route::post('registration',[UserController::class,'Registration']);
Route::post('login',[UserController::class,'Login']);
Route::post('ForgetPassword',[UserController::class,'ForgetPassword']);
Route::post('OtpVerification',[UserController::class,'OtpVerification']);
Route::post('ResetPassword',[UserController::class,'ResetPassword']);



Route::group(['middleware'=>'auth:api'],function(){

    Route::post('UpdatePassword',[UserController::class,'UpdatePassword']);
    Route::post('ProfileSetup',[UserController::class,'ProfileSetup']);
    Route::post('Follow',[UserController::class,'Follow']);
    Route::post('myfollowers',[UserController::class,'MyFollowers']);

    Route::post('AddPost',[RestaurentController::class,'AddPost']);
    Route::post('GetAllFriendPost',[RestaurentController::class,'GetAllFriendPost']);
    Route::post('AddComments',[RestaurentController::class,'AddComments']);
    Route::post('GetAllComments',[RestaurentController::class,'GetAllComments']);
    Route::post('AddStory',[RestaurentController::class,'AddStory']);
    Route::post('GetStory',[RestaurentController::class,'GetStory']);
    Route::post('LikePost',[RestaurentController::class,'LikePost']);
    Route::post('ActivityNotifications',[RestaurentController::class,'ActivityNotifications']);
    Route::post('GetAllUsers',[RestaurentController::class,'GetAllUsers']);
    Route::get('GetAllCategoryWithFoods',[RestaurentController::class, 'GetAllCategoryWithFoods']);
    Route::post('GetAllRestaurants',[RestaurentController::class, 'GetAllRestaurants']);
    Route::post('SingleProfile',[RestaurentController::class, 'SingleProfile']);
    Route::post('GetRestaurantMenuPost',[RestaurentController::class, 'GetRestaurantMenuPost']);

});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
