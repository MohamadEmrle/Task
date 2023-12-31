<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IdentityController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ProfileController;
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
})->name('site.dashboard');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin' , 'middleware' => 'auth'],function(){
    Route::resources(['dashboard' => DashboardController::class]);
    Route::get('/logout' ,[DashboardController::class,'logout'])->name('admin.logout');
});
Route::group(['prefix' => 'admin' , 'middleware' => 'auth'],function(){
    Route::resources(['category' => CategoryController::class]);
    Route::resources(['image' => ImageController::class]);
    Route::resources(['service' => ServiceController::class]);
    Route::resources(['content' => ContentController::class]);
    Route::resources(['customer' => CustomerController::class]);
    Route::resources(['about' => AboutController::class]);
});
