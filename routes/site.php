<?php

use App\Http\Controllers\Site\AbouttController;
use App\Http\Controllers\Site\CategoryeController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\ServiceController;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/services' ,[ServiceController::class,'index'])->name('site.index');
});

Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/categories' ,[CategoryeController::class,'index'])->name('site.categories');
    Route::get('/category/show/{id}' ,[CategoryeController::class,'show'])->name('site.category.show');
});

Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/abouts' ,[AbouttController::class,'index'])->name('site.abouts');
});

Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/contact' ,[ContactController::class,'index'])->name('site.contact');
    Route::post('/contact/store' ,[ContactController::class,'store'])->name('site.contact.store');
});
?>
