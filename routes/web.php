<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    return '<h1>All Cache cleared</h1>';
});

Route::get('/', function(){
    return view('auth/login');
})->name('login');

Auth::routes();


Route::group(['middleware'=>['ForAdminPanel']],function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('users', [AdminController::class, 'users'])->name('users');
    
    Route::get('category',[CategoryController::class, 'category'])->name('category');
    Route::get('add_food_category',[CategoryController::class, 'add_food_category'])->name('add_food_category');
    Route::post('add_category_to_db',[CategoryController::class, 'add_category_to_db']);
    Route::post('deleteFoodCategory/{id}',[CategoryController::class, 'deleteFoodCategory']);

    Route::get('food',[FoodController::class, 'index'])->name('Foods');
    Route::get('add_food',[FoodController::class, 'create']);
    Route::post('add_food_to_db',[FoodController::class, 'store']);
    Route::post('deleteFood/{id}',[FoodController::class, 'delete']);

    Route::get('post',[PostController::class, 'index'])->name('post');
    Route::post('edit',[PostController::class,'edit_post'])->name('edit');
    Route::post('deletePost/{id}',[PostController::class, 'delete']);

});