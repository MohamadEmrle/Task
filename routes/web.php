<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.pages.login');
});
// Start Login Controller
Route::group(['namespace' => 'Admin' ,'prefix' => 'admin'],function(){
    Route::get('login',[LoginController::class,'index'])->name('admin.index');
    Route::post('store',[LoginController::class,'store'])->name('admin.store');
});
// End Login Controller
// Start Dashboard Controller
Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'check'],function(){
    Route::get('/dashboard' ,[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/logout' ,[DashboardController::class,'logout'])->name('admin.logout');
});
// End Dashboard Controller

// Start Category Controller
Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'check'],function(){
    Route::get('/categories' ,[CategoryController::class,'categories'])->name('admin.categories');
    Route::get('/category/index' ,[CategoryController::class,'index'])->name('admin.category.index');
    Route::post('/category/store' ,[CategoryController::class,'store'])->name('admin.category.store');
    Route::get('/category/edit/{id}' ,[CategoryController::class,'edit'])->name('admin.category.edit');
    Route::post('/category/update' ,[CategoryController::class,'update'])->name('admin.category.update');
    Route::get('/category/delete/{id}' ,[CategoryController::class,'delete'])->name('admin.category.delete');
});
// End Category Controller

// Start Image Controller
Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'check'],function(){
    Route::get('/images' ,[ImageController::class,'images'])->name('admin.images');
    Route::get('/image/index' ,[ImageController::class,'index'])->name('admin.image.index');
    Route::post('/image/store' ,[ImageController::class,'store'])->name('admin.image.store');
    Route::get('/image/edit/{id}' ,[ImageController::class,'edit'])->name('admin.category.edit');
    Route::post('/image/update',[ImageController::class, 'update'])->name('admin.image.update');
    Route::get('/image/delete/{id}' ,[ImageController::class,'delete'])->name('admin.image.delete');

});
// End Image Controller
