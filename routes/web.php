<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IdentityController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Site\SiteController;
use App\Models\Category;
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
    $categories = Category::all();
    return view('site.pages.index',compact('categories'));
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Start Dashboard Controller
Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'auth'],function(){
    Route::get('/dashboard' ,[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/logout' ,[DashboardController::class,'logout'])->name('admin.logout');
});
// End Dashboard Controller

// Start Category Controller
Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'auth'],function(){
    Route::get('/categories' ,[CategoryController::class,'categories'])->name('admin.categories');
    Route::get('/category/index' ,[CategoryController::class,'index'])->name('admin.category.index');
    Route::post('/category/store' ,[CategoryController::class,'store'])->name('admin.category.store');
    Route::get('/category/edit/{id}' ,[CategoryController::class,'edit'])->name('admin.category.edit');
    Route::post('/category/update' ,[CategoryController::class,'update'])->name('admin.category.update');
    Route::get('/category/delete/{id}' ,[CategoryController::class,'delete'])->name('admin.category.delete');
});
// End Category Controller

// Start Image Controller
Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'auth'],function(){
    Route::get('/images' ,[ImageController::class,'images'])->name('admin.images');
    Route::get('/image/index' ,[ImageController::class,'index'])->name('admin.image.index');
    Route::post('/image/store' ,[ImageController::class,'store'])->name('admin.image.store');
    Route::get('/image/edit/{id}' ,[ImageController::class,'edit'])->name('admin.image.edit');
    Route::post('/image/update',[ImageController::class, 'update'])->name('admin.image.update');
    Route::get('/image/delete/{id}' ,[ImageController::class,'delete'])->name('admin.image.delete');

});
// End Image Controller

// Start Service Controller

Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'auth'],function(){
    Route::get('/services' ,[ServiceController::class,'index'])->name('admin.services');
    Route::get('/service/create' ,[ServiceController::class,'create'])->name('admin.service.create');
    Route::post('/service/store' ,[ServiceController::class,'store'])->name('admin.service.store');
    Route::get('/service/edit/{id}' ,[ServiceController::class,'edit'])->name('admin.service.edit');
    Route::post('/service/update',[ServiceController::class, 'update'])->name('admin.service.update');
    Route::get('/service/delete/{id}' ,[ServiceController::class,'destroy'])->name('admin.service.delete');


});
// End Service Controller

// Start Content Controller

Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'auth'],function(){
    Route::get('/contents' ,[ContentController::class,'index'])->name('admin.contents');
    Route::get('/content/create' ,[ContentController::class,'create'])->name('admin.content.create');
    Route::post('/content/store' ,[ContentController::class,'store'])->name('admin.content.store');
    Route::get('/content/edit/{id}' ,[ContentController::class,'edit'])->name('admin.content.edit');
    Route::post('/content/update',[ContentController::class, 'update'])->name('admin.content.update');
    Route::get('/content/delete/{id}' ,[ContentController::class,'destroy'])->name('admin.content.delete');


});
// End Content Controller

// Start Customer Controller

Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'auth'],function(){
    Route::get('/customers' ,[CustomerController::class,'index'])->name('admin.customers');
    Route::get('/customer/create' ,[CustomerController::class,'create'])->name('admin.customer.create');
    Route::post('/customer/store' ,[CustomerController::class,'store'])->name('admin.customer.store');
    Route::get('/customer/edit/{id}' ,[CustomerController::class,'edit'])->name('admin.customer.edit');
    Route::post('/customer/update',[CustomerController::class, 'update'])->name('admin.customer.update');
    Route::get('/customer/delete/{id}' ,[CustomerController::class,'destroy'])->name('admin.customer.delete');


});
// End Customer Controller

// Start Identities Controller

Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' , 'middleware' => 'auth'],function(){
    Route::get('/identities' ,[IdentityController::class,'index'])->name('admin.identities');
    Route::get('/identitie/create' ,[IdentityController::class,'create'])->name('admin.identitie.create');
    Route::post('/identitie/store' ,[IdentityController::class,'store'])->name('admin.identitie.store');
    Route::get('/identitie/edit/{id}' ,[IdentityController::class,'edit'])->name('admin.identitie.edit');
    Route::post('/identitie/update',[IdentityController::class, 'update'])->name('admin.identitie.update');
    Route::get('/identitie/delete/{id}' ,[IdentityController::class,'destroy'])->name('admin.identitie.delete');


});
// End Identities Controller
